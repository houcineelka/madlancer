<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;

class CartDrawerComponent extends Component
{
    public $cart    = [];
    protected $listeners = ['cart-updated' => 'cartUpdated'];


    public function mount()
    {
        $this->cart = session('cart', []);
    }
    public function render()
    {
        return view('livewire.services.cart-drawer');
    }

    public function itemTotalPrice($id)
    {
        $total = 0;

        foreach ($this->cart as $key => $item) {

            // Check if  exists
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

        return $total;

    }


    public function remove($id)
    {
        $cart = $this->cart;

        foreach ($cart as $key => $item) {

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

        // Update cart
        $this->cart = $cart;

        $this->dispatchBrowserEvent('alert',[
            "message" => __('messages.t_item_removed_from_cart_success'),"type"=> "success"]);

        $this->dispatchBrowserEvent('cart-updated');
    }


    public function total()
    {
        $total = 0;

        foreach ($this->cart as $key => $item) {
            // Update total
            $total += $this->itemTotalPrice($item['id']);
        }
        return $total;
    }



    public function cartUpdated()
    {
        $this->cart = session('cart', []);
    }

}
