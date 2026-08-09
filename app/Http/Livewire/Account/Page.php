<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.account.page')->extends('layouts.myL')->section('main');
    }
}
