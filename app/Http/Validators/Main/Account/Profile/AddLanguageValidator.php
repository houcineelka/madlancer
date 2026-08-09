<?php

namespace App\Http\Validators\Main\Account\Profile;

use Illuminate\Support\Facades\Validator;

class AddLanguageValidator
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
                'add_language_name'  => 'required|max:100',
                'add_language_level' => 'required|in:basic,conversational,fluent,native'
            ];

            // Set errors messages
            $messages = [
                'add_language_name.required'  => __('messages.t_validator_required'),
                'add_language_name.max'       => __('messages.t_validator_max', ['max' => 100]),
                'add_language_level.required' => __('messages.t_validator_required'),
                'add_language_level.in'       => __('messages.t_validator_in')
            ];
            // Set data to validate
            $data     = [
                'add_language_name'  => $request->add_language_name,
                'add_language_level' => $request->add_language_level,
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
