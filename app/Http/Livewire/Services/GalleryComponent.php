<?php

namespace App\Http\Livewire\Services;

use Livewire\Component;

class GalleryComponent extends Component
{
    public $gig;
    
    public function mount($gig)
    {
        $this->gig=$gig;
    }
    public function render()
    {
        return view('livewire.services.gallery-component');
    }
}
