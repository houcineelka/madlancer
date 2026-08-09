<?php

namespace App\Http\Livewire\Seller\Orders;

use App\Models\OrderItem;
use Livewire\Component;

class DetailsComponent extends Component
{
    public $item;

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
        return view('livewire.seller.orders.details')->extends('layouts.myL')->section('main');
    }
}
