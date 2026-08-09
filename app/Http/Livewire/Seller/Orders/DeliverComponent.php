<?php

namespace App\Http\Livewire\Seller\Orders;

use App\Http\Validators\Main\Seller\Orders\DeliverValidator;
use App\Models\OrderItem;
use App\Models\OrderItemWork;
use App\Models\OrderItemWorkConversation;
use App\Notifications\User\Buyer\OrderDelivered;
use App\Notifications\User\Buyer\DeliveredWorkNewMessage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class DeliverComponent extends Component
{
    use WithFileUploads;

    public $item;

    public $work;
    public $quick_response;

    public $message;

    /**
     * Init component
     *
     * @param string $id
     * @return void
     */
    public function mount($id)
    {
        // Get order item, only its owner (seller) can access it
        $this->item = OrderItem::where('uid', $id)
                                ->where('owner_id', auth()->id())
                                ->firstOrFail();
    }

    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.seller.orders.deliver', [
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
     * Deliver work to the buyer
     *
     * @return void
     */
    public function deliver()
    {
        try {

            // Order item must still be active
            if ($this->item->is_finished || !in_array($this->item->status, ['pending', 'proceeded'])) {

                $this->dispatchBrowserEvent('alert', [
                    "message" => __('messages.t_this_order_already_finished_cant_deliver'),
                    "type"    => "error"
                ]);

                return;

            }

            // Validate form
            DeliverValidator::validate($this);

            // Set attached work if any
            $attached_work = null;

            if ($this->work) {

                // Generate unique id for the file
                $work_uid  = uid();

                // Get file extension
                $extension = $this->work->getClientOriginalExtension();

                // Move file to local storage
                $this->work->storeAs('orders/delivered_work', $work_uid . '.' . $extension, 'custom');

                $attached_work = [
                    'id'        => $work_uid,
                    'extension' => $extension,
                    'name'      => $this->work->getClientOriginalName(),
                    'size'      => $this->work->getSize(),
                ];

            }

            // Save delivery
            $delivery                 = new OrderItemWork();
            $delivery->uid            = uid();
            $delivery->order_item_id  = $this->item->id;
            $delivery->attached_work  = $attached_work;
            $delivery->quick_response = clean($this->quick_response);
            $delivery->save();

            // Update item status
            $this->item->status       = 'delivered';
            $this->item->delivered_at = now();
            $this->item->save();

            // Refresh item
            $this->item->refresh();

            // Notify buyer that his order item has been delivered
            $this->item->order->buyer->notify( (new OrderDelivered($this->item))->locale(config('app.locale')) );

            // Send notification
            notification([
                'text'    => 't_seller_has_delivered_ur_order',
                'action'  => url('account/orders/files?orderId=' . $this->item->order->uid . '&itemId=' . $this->item->uid),
                'user_id' => $this->item->order->buyer_id,
                'params'  => ['seller' => auth()->user()->username]
            ]);

            // Reset form
            $this->reset(['work', 'quick_response']);

            // Success
            $this->dispatchBrowserEvent('alert', [
                "message" => __('messages.t_toast_operation_success')
            ]);

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
            $conversation               = new OrderItemWorkConversation();
            $conversation->item_id      = $this->item->id;
            $conversation->seller_id    = $this->item->owner_id;
            $conversation->buyer_id     = $this->item->order->buyer_id;
            $conversation->msg_from     = auth()->id();
            $conversation->msg_content  = clean($this->message);
            $conversation->save();

            // Notify buyer about this new message
            $this->item->order->buyer->notify( (new DeliveredWorkNewMessage($this->item, $conversation))->locale(config('app.locale')) );

            // Send notification
            notification([
                'text'    => 't_seller_sent_u_message_about_delivered_work',
                'action'  => url('account/orders/files?orderId=' . $this->item->order->uid . '&itemId=' . $this->item->uid),
                'user_id' => $this->item->order->buyer_id,
                'params'  => ['seller' => auth()->user()->username]
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
