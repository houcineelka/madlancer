<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class CompleteRegister extends Component
{
    public $step =1;
    public $title = 'Welcome to <span class="hr-accent">Mad</span>lancer, ';
    public $text = 'MadLancer is the world\'s work marketplace connecting businesses with independent talent';
    public function nextStep()
    {
        $this->step++;
        $this->etat();
    }

    public function back()
    {
        $this->step--;
        $this->etat();
    }

    public function etat()
    {
        if ($this->step == 1) {
            $this->title = 'Welcome to <span class="hr-accent">Mad</span>lancer, ';
            $this->text = 'MadLancer is the world\'s work marketplace connecting businesses with independent talent';        } elseif ($this->step == 2) {
            $this->title = 'Just <span class="hr-accent">One</span> more step to complete your profile, ';
            $this->text = 'MadLancer is the world\'s work marketplace connecting businesses with independent talent';        }  else {

        }
    }

    public function render()
    {
        
        return view('livewire.auth.complete-register')->extends('layouts.myL')->section('main');
    }
}
