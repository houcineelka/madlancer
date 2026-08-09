<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;

class CartComponent extends Component
{
    public $cart    = [];
    protected $listeners = ['cart-updated' => 'cartUpdated'];


    public function mount()
    {
        $this->cart = session('cart', []);
    }
    public function render()
    {
        return view('livewire.services.cart-component');
    }


    public function cartUpdated()
    {
        $this->cart = session('cart', []);
    }

}
