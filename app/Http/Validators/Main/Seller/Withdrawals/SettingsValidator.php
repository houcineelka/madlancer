<?php

namespace App\Http\Validators\Main\Seller\Withdrawals;

use Illuminate\Support\Facades\Validator;

class SettingsValidator
{
    
    /**
     * Validate form
     *
     * @param object $request
     * @return void
     */
    static function validate($request)
    {
        try {

            // Set rules
            $rules    = [
                'email'  => 'required|email|max:60'
            ];

            // Set errors messages
            $messages = [
                'email.required' => __('messages.t_validator_required'),
                'email.email'    => __('messages.t_validator_email'),
                'email.max'      => __('messages.t_validator_max', ['max' => 60]),
            ];

            // Set data to validate
            $data     = [
                'email' => $request->email
            ];

            // Validate data
            Validator::make($data, $rules, $messages)->validate();

            // Reset validation
            $request->resetValidation();

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
