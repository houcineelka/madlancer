<?php

namespace App\Http\Livewire\Account\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemWork;
use App\Models\OrderItemWorkConversation;
use App\Notifications\User\Seller\DeliveredWorkNewMessage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class FilesComponent extends Component
{
    public $item;
    public $message;

    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // Get order, only its buyer can access it
        $order = Order::where('uid', request()->query('orderId'))
                       ->where('buyer_id', auth()->id())
                       ->firstOrFail();

        // Get order item
        $this->item = OrderItem::where('uid', request()->query('itemId'))
                                ->where('order_id', $order->id)
                                ->firstOrFail();
    }

    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.account.orders.files', [
            'deliveries'   => $this->deliveries,
            'conversation' => $this->conversation,
        ])->extends('layouts.myL')->section('main');
    }

    /**
     * Get delivery history for this item
     *
     * @return object
     */
    public function getDeliveriesProperty()
    {
        return OrderItemWork::where('order_item_id', $this->item->id)->latest()->get();
    }

    /**
     * Get conversation about this item's delivered work
     *
     * @return object
     */
    public function getConversationProperty()
    {
        return OrderItemWorkConversation::where('item_id', $this->item->id)->oldest('created_at')->get();
    }

    /**
     * Send a message about the delivered work
     *
     * @return void
     */
    public function send()
    {
        try {

            // Validate form
            Validator::make(['message' => $this->message], [
                'message' => 'required|max:750'
            ], [
                'message.required' => __('messages.t_validator_required'),
                'message.max'      => __('messages.t_validator_max', ['max' => 750]),
            ])->validate();

            // Save message
            $conversation              = new OrderItemWorkConversation();
            $conversation->item_id     = $this->item->id;
            $conversation->seller_id   = $this->item->owner_id;
            $conversation->buyer_id    = auth()->id();
            $conversation->msg_from    = auth()->id();
            $conversation->msg_content = clean($this->message);
            $conversation->save();

            // Notify seller about this new message
            $this->item->owner->notify( (new DeliveredWorkNewMessage($this->item, $conversation))->locale(config('app.locale')) );

            // Send notification
            notification([
                'text'    => 't_buyer_sent_u_message_about_delivered_files',
                'action'  => url('seller/orders/deliver', $this->item->uid),
                'user_id' => $this->item->owner_id,
                'params'  => ['buyer' => auth()->user()->username]
            ]);

            // Reset form
            $this->reset('message');

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_toast_something_went_wrong'),
                "type"    => "error"
            ]);

            throw $th;

        }
    }

}
