<?php

namespace App\Http\Livewire\Seller;

use App\Models\Gig;
use App\Models\OrderItem;
use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        $seller = auth()->user();

        return view('livewire.seller.dashboard', [
            'gigsCount'    => Gig::where('user_id', $seller->id)->count(),
            'ordersQueue'  => OrderItem::where('owner_id', $seller->id)->whereIn('status', ['pending', 'proceeded'])->count(),
            'gigs'         => Gig::where('user_id', $seller->id)->latest()->take(6)->get(),
            'recentOrders' => OrderItem::where('owner_id', $seller->id)->latest()->take(8)->get(),
        ])->extends('layouts.myL')->section('main');
    }
}
