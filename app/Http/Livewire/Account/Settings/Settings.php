<?php

namespace App\Http\Livewire\Account\Settings;

use App\Models\Country;
use Livewire\Component;
use App\Http\Validators\Main\Account\Settings\EditValidator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Settings extends Component
{
    public $username;
    public $email;
    public $fullname;
    public $country;
    public $password;

    /**
     * Init component
     *
     * @return void
     */
    public function mount()
    {
        // Get user
        $user = auth()->user();

        // Fill form
        $this->fill([
            'username'    => $user->username,
            'email'       => $user->email,
            'fullname'    => $user->fullname,
            'country'     => $user->country_id
        ]);
    }

    public function render()
    {
        return view('livewire.account.settings.settings', [
            'countries' => $this->countries
        ])->extends('layouts.myL')->section('main');
    }

     /**
     * Get list of countries
     *
     * @return object
     */
    public function getCountriesProperty()
    {
        return Country::where('is_active', true)->orderBy('name', 'asc')->get();
    }

    /**
     * Update user account settings
     *
     * @return void
     */
    public function update()
    {
        try {

            // Validate form
            EditValidator::validate($this);

            // Set current user
            $user = auth()->user();

            // Validate current password
            if (!Hash::check($this->password, $user->password)) {
                
                // Password does not match
                $this->dispatchBrowserEvent('alert',[
                    "message" => __('messages.t_ur_current_pass_does_not_match'),
                    "type"    => "error"
                ]);

                return;

            }

            // Update user data
            User::where('id', auth()->id())->update([
                'username'    => clean($this->username),
                'email'       => clean($this->email),
                'fullname'    => $this->fullname ? clean($this->fullname) : null,
                'country_id'  => $this->country ? $this->country : null
            ]);

            // Refresh user
            $user->refresh();

            // Reset password input
            $this->reset('password');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_ur_account_settings_updated'),
                "type"    => "success"
            ]);


        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_form_validation_error'),
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_toast_something_went_wrong'),
                "type"    => "error"
            ]);

            throw $th;

        }
    }


}
