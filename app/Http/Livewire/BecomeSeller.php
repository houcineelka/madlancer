<?php

namespace App\Http\Livewire;

use App\Models\Level;
use App\Notifications\User\Seller\YouBecameSeller;
use Livewire\Component;

class BecomeSeller extends Component
{
    public function render()
    {
        return view('livewire.become-seller')->extends('layouts.myL')->section('main');
    }

    /**
     * Convert the current buyer account into a seller account
     *
     * @return void
     */
    public function confirm()
    {
        if (auth()->user()->account_type === 'seller') {
            return redirect('seller/home');
        }

        $level = Level::where('account_type', 'seller')->orderBy('seller_sales_min')->first();

        auth()->user()->update([
            'account_type' => 'seller',
            'level_id'     => $level?->id,
        ]);

        auth()->user()->notify((new YouBecameSeller())->locale(config('app.locale')));

        $this->dispatchBrowserEvent('alert', [
            "message" => __('messages.t_congratulations') . '! ' . __('messages.t_become_a_seller_subtitle'),
            "type"    => "success"
        ]);

        return redirect('seller/home');
    }
}
