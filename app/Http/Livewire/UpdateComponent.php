<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UpdateComponent extends Component
{
    public function render()
    {
        return view('livewire.update-component')->extends('layouts.updateL')->section('main');
    }
}
