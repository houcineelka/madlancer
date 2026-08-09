<?php

namespace App\Http\Livewire\Account\Refunds;

use App\Http\Validators\Main\Account\Refunds\RequestValidator;
use App\Models\OrderItem;
use App\Models\Refund;
use Carbon\Carbon;
use Livewire\Component;

class RequestComponent extends Component
{
    public $item;
    public $reason;
    public $canRefund = false;

    public function mount($id)
    {
        $item = OrderItem::where('uid', $id)
                          ->whereHas('order', function ($query) {
                              return $query->where('buyer_id', auth()->id());
                          })
                          ->firstOrFail();

        $this->item = $item;

        if ($item->refund) {
            return redirect(url('account/refunds/details', $item->refund->uid));
        }

        $this->canRefund = $this->itemIsRefundable($item);
    }

    private function itemIsRefundable(OrderItem $item)
    {
        if (!$item->expected_delivery_date || $item->is_finished) {
            return false;
        }

        $expected = Carbon::parse($item->expected_delivery_date);

        if ($expected->isPast()) {
            return in_array($item->status, ['delivered', 'proceeded', 'pending']);
        }

        return $item->status === 'delivered';
    }

    public function render()
    {
        return view('livewire.account.refunds.request')->extends('layouts.myL')->section('main');
    }

    public function submit()
    {
        if (!$this->canRefund || $this->item->refund) {
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_u_cant_request_refund_for_this_item_now'),
                "type"    => "error"
            ]);

            return;
        }

        RequestValidator::validate($this);

        $refund = Refund::create([
            'uid'       => uid(),
            'item_id'   => $this->item->id,
            'seller_id' => $this->item->owner_id,
            'buyer_id'  => auth()->id(),
            'reason'    => strip_tags($this->reason),
            'status'    => 'pending',
        ]);

        notification([
            'text'    => 't_buyer_opened_new_refund_dispute',
            'action'  => url('account/refunds/details', $refund->uid),
            'user_id' => $this->item->owner_id,
            'params'  => ['buyer' => auth()->user()->username]
        ]);

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_dispute_opened'),
            "type"    => "success"
        ]);

        return redirect(url('account/refunds/details', $refund->uid));
    }
}
