<?php

namespace App\Http\Livewire\Account\Reviews;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.account.reviews.reviews', [
            'written'  => $this->written,
            'received' => auth()->user()->account_type === 'seller' ? $this->received : null,
        ])->extends('layouts.myL')->section('main');
    }

    public function getWrittenProperty()
    {
        return Review::where('user_id', auth()->id())
                      ->latest()
                      ->paginate(10, ['*'], 'written');
    }

    public function getReceivedProperty()
    {
        return Review::where('seller_id', auth()->id())
                      ->latest()
                      ->paginate(10, ['*'], 'received');
    }
}
