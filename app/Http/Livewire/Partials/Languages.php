<?php

namespace App\Http\Livewire\Partials;

use App\Models\Language;
use Livewire\Component;

class Languages extends Component
{
    public $default_language_name;
    public $default_language_code;
    public $default_country_code;


    public function mount()
    {
        // Get language from session
        $locale   = session()->has('locale') ? session()->get('locale') : settings('general')->default_language;

        // Get default language
        $language = Language::where('language_code', $locale)->first();

        // Check if language exists
        if ($language) {
            
            // Set default language
            $this->default_language_name = $language->name;
            $this->default_language_code = $language->language_code;
            $this->default_country_code  = $language->country_code;

        } else {

            // Not found, set default
            $this->default_language_name = "Arabic";
            $this->default_language_code = "ar";
            $this->default_country_code  = "ae";

        }
    }

    public function render()
    {
        return view('livewire.partials.languages');
    }

    public function setLocale($locale)
    {
        // Get language
        $language = Language::where('language_code', $locale)->where('is_active', true)->first();

        // Check if language exists
        if (!$language) {
            
            // Not found
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_selected_lang_does_not_found'),
                "type"    => "error"
            ]);

            return;

        }

        // Set default language
        session()->put('locale', $language->language_code);

        // Refresh the page
        $this->dispatchBrowserEvent('refresh');
    }
}
