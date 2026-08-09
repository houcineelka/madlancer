<?php

namespace App\Http\Livewire\Cart;

use App\Models\Gig;
use App\Models\GigUpgrade;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart;

    public function mount()
    {
        $this->cart = session('cart', []);
    }
    public function render()
    {
        return view('livewire.cart.cart-component')->extends('layouts.myL')->section('main');
    }

    public function remove($id)
    {
        $cart = $this->cart;

        foreach ($cart as $key => $item) {
            
            //  if item exists 
            if ($item['id'] === $id) {
                
                unset($cart[$key]);
                
                break;
            }
        }

        // Refresh cart
        array_values($cart);

        session()->forget('cart');

        // Set new cart
        session()->put('cart', $cart);

        // Update 
        $this->cart = $cart;

        $this->dispatchBrowserEvent('alert',[ "message" => __('messages.t_item_removed_from_cart_success'),"type" =>"success"]);
    }


 
    public function itemTotalPrice($id)
    {
        $total = 0;

        foreach ($this->cart as $key => $item) {
            
            //  if item exists
            if ($item['id'] === $id) {
                
                // Get quantity
                $quantity = (int) $item['quantity'];

                // Sum upgrades 
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

                    // No upgrades 
                    $total_upgrades_price = 0;

                }

                //  new total
                $total = ($quantity * $item['gig']['price']) + ($total_upgrades_price * $quantity);

            }

        }

        // Return total 
        return $total;

    }


    public function subtotal()
    {
        $subtotal = $this->total();

        return $subtotal;
    }


   
    public function taxes()
    {
        //  select commission 
        $settings = settings('commission');

        //  if taxes enabled
        if ($settings->enable_taxes) {
            
            if ($settings->tax_type === 'percentage') {
                
                // Get tax 
                $tax = bcmul($this->total(), $settings->tax_value) / 100;

                return $tax;

            } else {
                
                // Fixed price
                $tax = $this->total() - $settings->tax_value;

                return $tax;

            }

        } else {

            // Taxes not enabled
            return 0;

        }
    }


  
    public function total()
    {
        $total = 0;

        foreach ($this->cart as $key => $item) {
            
            $total += $this->itemTotalPrice($item['id']);

        }

        return $total;
    }



    public function checkout()
    {
     
        //validate data before send user to payment
        $cart = $this->cart;

        foreach ($cart as $key => $item) {
            
            $gig = Gig::where('uid', $item['id'])->where('status', 'active')->first();

            if ($gig) {
                
                // search for upgrades of items 
                if (is_array($item['upgrades']) && count($item['upgrades'])) {
                    
                    foreach ($item['upgrades'] as $index => $upgrade_id) {
                        
                        $upgrade = GigUpgrade::where('uid', $upgrade_id['id'])->where('gig_id', $gig->id)->first();

                        if ($upgrade) {
                            
                            //  if upgrade selected
                            if ($upgrade_id['checked']) {
                                
                                // Upgrade exist, update price, title, extra days
                                $cart[$key]['upgrades'][$index]['id']       = $upgrade->uid;
                                $cart[$key]['upgrades'][$index]['title']    = $upgrade->title;
                                $cart[$key]['upgrades'][$index]['price']    = $upgrade->price;
                                $cart[$key]['upgrades'][$index]['delivery'] = $upgrade->extra_days;

                            } else {

                                unset($cart[$key]['upgrades'][$index]);

                                array_values($cart[$key]['upgrades']);

                            }

                        } else {

                            
                            unset($cart[$key]['upgrades'][$index]);

                            // Refresh 
                            array_values($cart[$key]['upgrades']);

                            session()->forget('cart');

                            // Refresh session
                            session()->put('cart', $cart);

                            $this->dispatchBrowserEvent('alert',["message" => __('messages.t_an_upgrade_in_item_in_cart_not_found'),"type"=> "error"]);

                            return;

                        }

                    }

                } else {

                    // Set empty upgrades
                    $cart[$key]['upgrades'] = [];

                }

                //  quantity must be between 1 and 10
                if (!in_array($cart[$key]['quantity'], range(1, 10))) {
                    
                    $this->dispatchBrowserEvent('alert',["message" => __('messages.t_selected_quantity_is_not_correct'),"type"=> "error"]);

                    return;

                }
                
            } else {

             
                unset($cart[$key]);

                // Refresh cart
                array_values($cart);

                session()->forget('cart');

                // Refresh session
                session()->put('cart', $cart);

                $this->dispatchBrowserEvent('alert',[ "message" => __('messages.t_an_item_in_your_cart_doesnot_exist'),"type"=> "error"]);

                return;

            }

        }

        session()->forget('cart');

        // Refresh  cart 
        array_values($cart);

        // Update cart
        session()->put('cart', $cart);

        return redirect('checkout');
    }
    
}
