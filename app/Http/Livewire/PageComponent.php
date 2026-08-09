<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Livewire\Component;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class PageComponent extends Component
{
    use SEOToolsTrait;

    public $page;

    /**
     * Initialize component
     *
     * @return mixed
     */
    public function mount($slug)
    {
        // Get page
        $this->page = Page::where('slug', $slug)->firstOrFail();

        // External pages redirect straight to their link
        if ($this->page->is_link && $this->page->link) {
            return redirect()->away($this->page->link);
        }
    }

    /**
     * Render component
     *
     * @return Illuminate\View\View
     */
    public function render()
    {
        // Seo
        $this->seo()->setTitle( setSeoTitle($this->page->title, true) );
        $this->seo()->setDescription( settings('seo')->description );

        return view('livewire.page-component')->extends('layouts.myL')->section('main');
    }
}
