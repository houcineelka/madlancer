<?php

namespace App\Http\Livewire\Auth;

use App\Models\Country;
use App\Models\User;
use Livewire\Component;

class CompleteRegisterStep1 extends Component
{
    public $countries ;
    public $country ;
    public $headline ;
    public $description ;
    public $toNext = false;

    public function mount()
    {
        
        $this->country = auth()->user()->country_id;
        $this->headline  = auth()->user()->headline;
        $this->description = auth()->user()->description;
        $this->countries =Country::all();
    }
    
    public function storeStep1()
    {
        $valid = $this->validate([
            "country"=>"required",
            "headline"=>"required|max:100|min:40",
            "description"=>"required|min:80",
        ],[
            'country.required' => __('messages.t_validator_required'),
            'headline.required' => __('messages.t_validator_required'),
            'headline.max'      => __('messages.t_validator_max', ['max' => 100]),
            'country.required' => __('messages.t_validator_required'),
            'description.required' => __('messages.t_validator_required'),
            'description.min'      => __('messages.t_validator_min', ['min' => 40]),
        ]);
        if ($valid) {
            $user = User::find(auth()->user()->id);
            $user->country_id = $this->country;
            $user->headline = $this->headline;
            $user->description = $this->description;
            $user->save();
            $this->toNext=true;
        }
    }
    
    public function render()
    {
        return view('livewire.auth.complete-register-step1');
    }
}
