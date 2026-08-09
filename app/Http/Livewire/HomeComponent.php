<?php

namespace App\Http\Livewire;

use App\Models\Gig;
use Livewire\Component;

class HomeComponent extends Component
{
    public $lat;
    public function mount()
    {
        $this->lat=Gig::latest('created_at')->take(8)->get();
    }
    public function render()
    {
        return view('livewire.home-component')->extends('layouts.myL')->section('main');
    }
}
