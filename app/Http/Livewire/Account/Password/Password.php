<?php

namespace App\Http\Livewire\Account\Password;

use App\Http\Validators\Main\Account\Password\EditValidator;
use App\Models\User;
use App\Notifications\User\Everyone\PasswordChanged;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;


    public function render()
    {
        return view('livewire.account.password.password')->extends('layouts.myL')->section('main');
    }

    
    /**
     * Update user account password
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
            if (!Hash::check($this->current_password, $user->password)) {
                
                // Password does not match
                $this->dispatchBrowserEvent('alert',[
                    "message" => __('messages.t_ur_current_pass_does_not_match'),
                    "type"    => "error"
                ]);

                return;

            }

            // Update user data
            User::where('id', auth()->id())->update([
                'password'    => Hash::make($this->new_password)
            ]);

            // Password changed
            $user->notify( (new PasswordChanged)->locale(config('app.locale')) );

            // Reset password input
            $this->reset();

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => __('messages.t_ur_account_password_updated'),
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
