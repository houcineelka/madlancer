<?php

namespace App\Http\Livewire\Checkout;

use App\Http\Validators\Main\Checkout\PlaceValidator;
use App\Models\Gig as ModelsGig;
use App\Models\GigUpgrade;
use App\Models\Order;
use App\Models\OrderInvoice;
use App\Models\OrderItem;
use App\Models\OrderItemUpgrade;
use App\Models\UserBilling;
use App\Notifications\User\Buyer\OrderPlaced;
use App\Notifications\User\Seller\PendingOrder;
use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Stripe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\StripeClient;
use Stripe\PaymentIntent;


class CheckoutComponent extends Component
{
    public $cart;
    public $token;

    
    public $payment_method = "credit_card";

    public $paypal_order_id;
    public $card_order_id;


    // infos
    public $firstname;
    public $lastname;
    public $email;
    public $company;
    public $address;
   

    protected $listeners = ['cart-updated' => 'cartUpdated','pay-method' => 'pay'];


    public function mount()
    {
   
        $this->validateCart();

        $cart = session('cart', []);

        if (is_array($cart) && count($cart)) {
            
            $this->cart = $cart;

            $this->paypal_order_id = session('paypal_order_id', null);
            $this->card_order_id = session('card_order_id', null);


            $billing               = UserBilling::firstOrCreate(['user_id' => auth()->id()]);
            
            $this->firstname       = $billing->firstname;
            $this->lastname        = $billing->lastname;
            $this->email           = auth()->user()->email;
            $this->company         = $billing->company;
            $this->address         = $billing->address;

           

        } else {
            return redirect('cart');
        }
    }

 

    public function render()
    {
        return view('livewire.checkout.checkout-component')->extends('layouts.myL')->section('main');
    }


    
    public function cartUpdated()
    {
        $cart = session('cart', []);

        if (count($cart) === 0) {
            return redirect('cart');
        }
    }


    public function validateCart()
    {
        $items = session('cart', []);

        if (is_array($items) && count($items)) {
            
            foreach ($items as $key => $item) {
                
                $id      = $item['id'];

                $user_id = auth()->id();

                $gig     = ModelsGig::where('uid', $id)->active()->where('user_id', '!=', $user_id)->first();

                if (!$gig) {
                    unset($items[$key]);
                }

            }
            array_values($items);

        }

        session()->forget('cart');

        session()->put('cart', $items);
    }


    public function itemTotalPrice($id)
    {
        // Set empty var total price
        $total = 0;

        // Loop throug items in cart
        foreach ($this->cart as $key => $item) {
            
            // Check if item exists
            if ($item['id'] === $id) {
                
                // Get quantity
                $quantity = (int) $item['quantity'];

                // Sum upgrades total price
                if (is_array($item['upgrades']) && count($item['upgrades'])) {
                    
                    $total_upgrades_price = array_reduce($item['upgrades'], function($i, $obj)
                    {
                        // Calculate only selected upgrades
                        if ($obj['checked'] == true) {
                            return $i += $obj['price'];
                        } else {
                            return $i;
                        }

                    });

                } else {

                    // No upgrades selected
                    $total_upgrades_price = 0;

                }

                // Set new total
                $total = ($quantity * $item['gig']['price']) + ($total_upgrades_price * $quantity);

            }

        }

        // Return total price
        return $total;

    }

     public function total()
    {
        // Set total empty variable
        $total = 0;

        // Loop through items in cart
        foreach ($this->cart as $key => $item) {
            
            // Update total price
            $total += $this->itemTotalPrice($item['id']);

        }

        // Return total price
        return $total;
    }


    public function subtotal()
    {
        // Calculate subtotal
        $subtotal = $this->total();

        // Return subtotal
        return $subtotal;
    }



    public function taxes()
    {
        // Get commission settings
        $settings = settings('commission');

        // Check if taxes enabled
        if ($settings->enable_taxes) {
            
            // Check if type of taxes percentage
            if ($settings->tax_type === 'percentage') {
                
                // Get tax amount
                $tax = bcmul($this->total(), $settings->tax_value) / 100;

                // Return tax amount
                return $tax;

            } else {
                
                // Fixed price
                $tax = $this->total() - $settings->tax_value;

                // Return tax
                return $tax;

            }

        } else {

            // Taxes not enabled
            return 0;

        }
    }


    public function commission($price)
    {
        // Get settings
        $settings = settings('commission');

        // Commission percentage
        if ($settings->commission_type === 'percentage') {
            
            // Calculate commission
            $commission = $settings->commission_value * $price / 100;

        } else {

            // Fixed amount
            $commission = $settings->commission_value;

        }

        // Return commission
        return $commission;
    }


    public function pay(Request $request)
    {
        // Prevent a double form submission (double click, slow network retry, etc.)
        // from placing the same order twice
        $lock_key = 'checkout-processing-' . auth()->id();

        if (Cache::has($lock_key)) {
            return;
        }

        Cache::put($lock_key, true, now()->addSeconds(30));

        try {


            // Check payment method
            if (!in_array($this->payment_method, ['paypal', 'credit_card', 'balance'])) {
               
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" => 'please choose a payment method',
                    "type"    => "error"
                ]);

                // Return
                return;

            }

            // Validate billing info
            PlaceValidator::validate($this);

            // Get payment gateways settings
            $gateways              = settings('gateways');

            // Get commission settings
            $settings              = settings('commission');

            // Set unique id for this order
            $uid                   = uid();

            // Get buyer id
            $buyer_id              = auth()->id();

            // Count taxes amount
            $taxes                 = $this->taxes();

            // Count subtotal amount
            $subtotal              = $this->subtotal();

            // Count total amount
            $total                 = $this->total() + $taxes;

            // Check if paypal payment selected
            if ($gateways->is_paypal && $this->payment_method === 'paypal') {
                // Set paypal provider and config
                $paypal_provider = new PayPalClient();
    
                // Get paypal access token
                $paypal_provider->getAccessToken();
    
                // Capture this order
                $paypal_order    = $paypal_provider->capturePaymentOrder($this->paypal_order_id);

                // Let's see if payment suuceeded
                if ( is_array($paypal_order) && $paypal_order['status'] === 'COMPLETED' ) {
                    
                    // Payment succeeded, but we need to verify that total price is same from paypal request
                    if ($total != $paypal_order['purchase_units'][0]['payments']['captures'][0]['amount']['value']) {
                        
                        // Payment amount not correct
                        $this->dispatchBrowserEvent('alert',[
                            "message" => 'amount from paypal not correct as cart',
                            "type"    => "error"
                        ]);
    
                        // Return
                        return;

                    }

                    // Set payment id
                    $payment_id     = $paypal_order['id'];

                    // Set payment method
                    $payment_method = 'paypal';

                } else {

                    // Paypal not completed
                    $this->dispatchBrowserEvent('alert',[
                        "message" => 'sorry we couldnt handle your paypal payment',
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }


            } else if ($gateways->is_stripe && $this->payment_method === 'credit_card') {
                Stripe\Stripe::setApiKey('sk_test_51N0VayFK3dRKEnb1muM0303es3L81hDLzFm8ZGOGfIB1bYCASgR87w9bXli9pnpr3pY4n2MmU8zsuNXZyU6luDNz00EvZPZdMH');

             
                $intent = PaymentIntent::create([
                    'amount' => ($this->total() + $this->taxes())*100,
                    'currency' => 'usd',
                    'payment_method' => $this->card_order_id, 
                    'confirm' => true,
                  ]);
             
                 // Set payment id
                 $payment_id     = $this->card_order_id;

                 // Set payment method
                 $payment_method = 'credit_card';

                    

            } else if ($this->payment_method === 'balance') {
                
                // Check if user has enough money
                if (auth()->user()->balance_available < $total) {
                    
                    // You don't have enough money
                    $this->dispatchBrowserEvent('alert',[
                        "message" => 'you dont have enough money to checkout',
                        "type"    => "error"
                    ]);

                    // Return
                    return;

                }

                // Set payment id
                $payment_id     = uid();

                // Set payment method
                $payment_method = 'balance';

            }

            // Save order
            $order                 = new Order();
            $order->uid            = $uid;
            $order->buyer_id       = $buyer_id;
            $order->total_value    = $total;
            $order->subtotal_value = $subtotal;
            $order->taxes_value    = $taxes;
            $order->save();

            // Now let's loop through items in this cart and save them
            foreach ($this->cart as $key => $item) {
                
                // Get gig
                $gig = ModelsGig::where('uid', $item['id'])->active()->first();

                // Check if gig exists
                if ($gig) {
                    
                    // Get item total price
                    $item_total_price                   = $this->itemTotalPrice($item['id']);

                    // Calculate commission first
                    $commisssion                        = $settings->commission_from === 'orders' ? $this->commission($item_total_price) : 0;

                    // Save order item
                    $order_item                         = new OrderItem();
                    $order_item->uid                    = uid();
                    $order_item->order_id               = $order->id;
                    $order_item->gig_id                 = $gig->id;
                    $order_item->owner_id               = $gig->user_id;
                    $order_item->quantity               = (int) $item['quantity'];
                    $order_item->has_upgrades           = is_array($item['upgrades']) && count($item['upgrades']) ? true : false;
                    $order_item->total_value            = $item_total_price;
                    $order_item->profit_value           = $item_total_price - $commisssion;
                    $order_item->commission_value       = $commisssion;
                    $order_item->save();

                    // Check if this item has upgrades
                    if ( is_array($item['upgrades']) && count($item['upgrades']) ) {
                        
                        // Loop through upgrades
                        foreach ($item['upgrades'] as $index => $upg) {
                            
                            // Get upgrade
                            $upgrade = GigUpgrade::where('uid', $upg['id'])->where('gig_id', $gig->id)->first();

                            // Check if upgrade exists
                            if ($upgrade) {
                                
                                // Save item upgrade
                                $order_item_upgrade             = new OrderItemUpgrade();
                                $order_item_upgrade->item_id    = $order_item->id;
                                $order_item_upgrade->title      = $upgrade->title;
                                $order_item_upgrade->price      = $upgrade->price;
                                $order_item_upgrade->extra_days = $upgrade->extra_days;
                                $order_item_upgrade->save();

                            }
                            
                        }

                    }

                    // Update seller pending balance
                    $gig->owner()->update([
                        'balance_pending' => $gig->owner->balance_pending + $order_item->profit_value
                    ]);

                    // Increment orders in queue
                    $gig->increment('orders_in_queue');

                    // Order item placed successfully
                    // Let's notify the seller about new order
                    $gig->owner->notify( (new PendingOrder($order_item))->locale(config('app.locale')) );

                    // Send notification
                    notification([
                        'text'    => 't_u_received_new_order_seller',
                        'action'  => url('seller/orders/details', $order_item->uid),
                        'user_id' => $order_item->owner_id
                    ]);

                }

            }

            // Save invoice
            $invoice                 = new OrderInvoice();
            $invoice->order_id       = $order->id;
            $invoice->payment_method = $payment_method;
            $invoice->payment_id     = $payment_id;
            $invoice->firstname      = clean($this->firstname);
            $invoice->lastname       = clean($this->lastname);
            $invoice->email          = clean($this->email);
            $invoice->company        = $this->company ? clean($this->company) : null;
            $invoice->address        = clean($this->address);
            $invoice->save();

            // Update user balance
            if ($this->payment_method === 'credit_card' || $this->payment_method === 'paypal') {
                auth()->user()->update([
                    'balance_purchases' => $total
                ]);
            } else if ($this->payment_method === 'balance') {
                auth()->user()->update([
                    'balance_purchases' => $total,
                    'balance_available' => auth()->user()->balance_available - $total
                ]);
            }

            // Now let's forget the paypal order id that we used to capture the payment
            session()->forget('paypal_order_id');

            // Now everything succeeded
            // Let's empty the cart
            session()->forget('cart');

            // Now let's notify the buyer that his order has been placed
            auth()->user()->notify( (new OrderPlaced($order, $total))->locale(config('app.locale')) );

            // After that the buyer has to send the seller the required form to start
            $this->dispatchBrowserEvent('alert',[
                "message" => 'your gig in progress thank u !!!',
                "type"    => "success"
            ]);

            // return redirect('/');
            return redirect('account/orders')->with('message', __('messages.t_u_have_send_reqs_asap_to_seller'));


        } catch (\Illuminate\Validation\ValidationException $e) {

            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {
            
            $this->dispatchBrowserEvent('alert',[
                "message" => $th->getMessage(),
                "type"    => "error"
            ]);

        } finally {

            // Release lock so the buyer can retry after an error
            Cache::forget($lock_key);

        }
    }

    public function updatedPaypalOrderId($orderId)
    {
        // Delete old value
        session()->forget('paypal_order_id');

        // Set new value
        session()->put('paypal_order_id', $orderId);
    }

   
}
