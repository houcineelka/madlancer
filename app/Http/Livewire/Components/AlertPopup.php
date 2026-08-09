<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class AlertPopup extends Component
{
    public $message="hellllllllllpppppppppp";
    public $type="danger";
    public $icon="error";

    public function render()
    {
        return view('livewire.components.alert-popup');
    }
}
