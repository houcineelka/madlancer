<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        $settings = settings('footer');

        return view('livewire.footer', [
            'termsPage'   => $settings->terms,
            'privacyPage' => $settings->privacy,
        ]);
    }
}
