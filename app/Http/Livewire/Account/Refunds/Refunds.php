<?php

namespace App\Http\Livewire\Account\Refunds;

use App\Models\Refund;
use Livewire\Component;
use Livewire\WithPagination;

class Refunds extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.account.refunds.refunds', [
            'refunds' => $this->refunds
        ])->extends('layouts.myL')->section('main');
    }

    public function getRefundsProperty()
    {
        return Refund::where('buyer_id', auth()->id())
                      ->orWhere('seller_id', auth()->id())
                      ->latest()
                      ->paginate(10);
    }
}
