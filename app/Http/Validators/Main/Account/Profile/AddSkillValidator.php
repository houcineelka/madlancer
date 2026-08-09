<?php

namespace App\Http\Validators\Main\Account\Profile;

use Illuminate\Support\Facades\Validator;
use Throwable;

class AddSkillValidator
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
                'add_skill_name'       => 'required|max:30',
                'add_skill_experience' => 'required|in:beginner,intermediate,pro'
            ];

            // Set errors messages
            $messages = [
                'add_skill_name.required'       => __('messages.t_validator_required'),
                'add_skill_name.max'            => __('messages.t_validator_max', ['max' => 30]),
                'add_skill_experience.required' => __('messages.t_validator_required'),
                'add_skill_experience.in'       => __('messages.t_validator_in'),
            ];

            // Set data to validate
            $data     = [
                'add_skill_name'       => $request->add_skill_name,
                'add_skill_experience' => $request->add_skill_experience,
            ];

            // Validate data
            Validator::make($data, $rules, $messages)->validate();

            // Reset validation
            $request->resetValidation();

        } catch (Throwable $th) {
            throw $th;
        }
    }

}
