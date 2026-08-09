<?php

namespace App\Http\Livewire\Account\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use App\Notifications\User\Seller\OrderItemCanceled;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.account.orders.orders', [
            'orders' => $this->orders
        ])->extends('layouts.myL')->section('main');
    }
    /**
     * Get list of orders
     *
     * @return object
     */
    public function getOrdersProperty()
    {
        return Order::where('buyer_id', auth()->id())->orderByDesc('id')->paginate(42);
    }


    /**
     * Cancel order 
     *
     * @param string $id
     * @return void
     */
    public function cancel($id)
    {
        // Get item
        $item = OrderItem::where('uid', $id)
                        ->whereHas('order', function($query) {
                            return $query->where('buyer_id', auth()->id());
                        })
                        ->where('status', 'pending')
                        ->firstOrFail();

        // Remove item price from seller balance
        $item->owner()->update([
            'balance_pending' => $item->owner->balance_pending - $item->profit_value
        ]);

        // Add item price to buyer balance
        $item->order->buyer()->update([
            'balance_available' => $item->order->buyer->balance_available + $item->total_value
        ]);

        // Update item
        $item->status      = 'canceled';
        $item->canceled_by = 'buyer';
        $item->canceled_at = now();
        $item->is_finished = true;
        $item->save();

        // Decrement orders in queue
        $item->gig()->decrement('orders_in_queue');

        // Check if item has any opened refund
        if ($item->refund && $item->refund?->status === 'pending') {
            
            // Let's close this refund
            $item->refund->status = 'closed';
            $item->refund->save();

        }

        // Send notification to seller
        $item->owner->notify( (new OrderItemCanceled($item))->locale(config('app.locale')) );

        // Send notification
        notification([
            'text'    => 't_buyer_has_canceled_order',
            'action'  => url('seller/orders/details', $item->uid),
            'user_id' => $item->owner_id,
            'params'  => ['buyer' => auth()->user()->username]
        ]);

        // success
        $this->dispatchBrowserEvent('alert',[
            "message" => __('messages.t_order_has_been_successfully_canceled')
        ]);
    }
    
}
