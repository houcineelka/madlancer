<?php

namespace App\Http\Livewire\Account\Refunds;

use App\Models\Refund;
use App\Models\RefundConversation;
use App\Models\User;
use Livewire\Component;

class DetailsComponent extends Component
{
    public $refund;
    public $messages;
    public $message;

    public function mount($id)
    {
        $refund = Refund::where('uid', $id)
                         ->where(function ($q) {
                             $q->where('buyer_id', auth()->id())->orWhere('seller_id', auth()->id());
                         })
                         ->firstOrFail();

        $this->refund   = $refund;
        $this->messages = $this->loadMessages();
    }

    private function loadMessages()
    {
        return RefundConversation::where('refund_id', $this->refund->id)
                                  ->oldest()
                                  ->get()
                                  ->map(function ($m) {
                                      $m->author = User::find($m->author_id);
                                      return $m;
                                  });
    }

    public function render()
    {
        return view('livewire.account.refunds.details', [
            'isSeller' => $this->isSeller
        ])->extends('layouts.myL')->section('main');
    }

    public function getIsSellerProperty()
    {
        return auth()->id() === $this->refund->seller_id;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|max:1500',
        ], [
            'message.required' => __('messages.t_validator_required'),
            'message.max'      => __('messages.t_validator_max', ['max' => 1500]),
        ]);

        RefundConversation::create([
            'uid'         => uid(),
            'refund_id'   => $this->refund->id,
            'author_type' => User::class,
            'author_id'   => auth()->id(),
            'message'     => strip_tags($this->message),
        ]);

        $otherUserId = $this->isSeller ? $this->refund->buyer_id : $this->refund->seller_id;

        notification([
            'text'    => 't_new_message_about_refund',
            'action'  => url('account/refunds/details', $this->refund->uid),
            'user_id' => $otherUserId,
        ]);

        $this->reset('message');
        $this->messages = $this->loadMessages();

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_refund_msg_posted_success'),
            "type"    => "success"
        ]);
    }

    public function accept()
    {
        if (!$this->isSeller || $this->refund->status !== 'pending') {
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_u_cant_do_action_for_this_refund'),
                "type"    => "error"
            ]);

            return;
        }

        $this->refund->status = 'accepted_by_seller';
        $this->refund->save();

        $item = $this->refund->item;

        $item->status      = 'refunded';
        $item->is_finished = true;
        $item->refunded_at = now();
        $item->save();

        User::where('id', $this->refund->buyer_id)->update([
            'balance_available' => $this->refund->buyer->balance_available + $item->total_value
        ]);

        User::where('id', $this->refund->seller_id)->update([
            'balance_pending' => $this->refund->seller->balance_pending - $item->profit_value
        ]);

        notification([
            'text'    => 't_seller_has_accepted_ur_refund',
            'action'  => url('account/refunds/details', $this->refund->uid),
            'user_id' => $this->refund->buyer_id,
            'params'  => ['seller' => auth()->user()->username]
        ]);

        $this->refund->refresh();

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_u_have_approved_this_refund'),
            "type"    => "success"
        ]);
    }

    public function reject()
    {
        if (!$this->isSeller || $this->refund->status !== 'pending') {
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_u_cant_do_action_for_this_refund'),
                "type"    => "error"
            ]);

            return;
        }

        $this->refund->status = 'rejected_by_seller';
        $this->refund->save();

        notification([
            'text'    => 't_seller_has_declined_ur_refund',
            'action'  => url('account/refunds/details', $this->refund->uid),
            'user_id' => $this->refund->buyer_id,
            'params'  => ['seller' => auth()->user()->username]
        ]);

        $this->refund->refresh();

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_u_have_declined_this_refund'),
        ]);
    }

    public function escalate()
    {
        if ($this->refund->buyer_id !== auth()->id() || $this->refund->status !== 'rejected_by_seller') {
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_u_cant_do_action_for_this_refund'),
                "type"    => "error"
            ]);

            return;
        }

        $this->refund->request_admin_intervention = true;
        $this->refund->save();

        $this->refund->refresh();

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_raise_dispute_request_received_success'),
            "type"    => "success"
        ]);
    }
}
