<?php

namespace App\Http\Validators\Admin\Services;

use Illuminate\Support\Facades\Validator;

class PaypalValidator
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
                'mode'          => 'required|in:sandbox,live',
                'client_id'     => 'required|max:120',
                'client_secret' => 'required|max:120'
            ];

            // Set errors messages
            $messages = [
                'mode.required'          => __('messages.t_validator_required'),
                'mode.in'                => __('messages.t_validator_in'),
                'client_id.required'     => __('messages.t_validator_required'),
                'client_id.max'          => __('messages.t_validator_max', ['max' => 120]),
                'client_secret.required' => __('messages.t_validator_required'),
                'client_secret.max'      => __('messages.t_validator_max', ['max' => 120])
            ];

            // Set data to validate
            $data     = [
                'mode'          => $request->mode,
                'client_id'     => $request->client_id,
                'client_secret' => $request->client_secret
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
