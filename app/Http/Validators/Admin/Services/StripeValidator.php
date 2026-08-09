<?php

namespace App\Http\Validators\Admin\Services;

use Illuminate\Support\Facades\Validator;

class StripeValidator
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
                'secret'  => 'required|max:120'
            ];

            // Set errors messages
            $messages = [
                'secret.required' => __('messages.t_validator_required'),
                'secret.max'      => __('messages.t_validator_max', ['max' => 120]),
            ];

            // Set data to validate
            $data     = [
                'secret' => $request->secret
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
