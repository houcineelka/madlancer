<?php

namespace App\Http\Livewire\Profile;

use App\Http\Validators\Main\Account\Profile\AvailabilityValidator;
use App\Http\Validators\Main\Account\Profile\AvatarValidator;
use App\Http\Validators\Main\Account\Profile\DescriptionValidator;
use App\Http\Validators\Main\Account\Profile\HeadlineValidator;
use App\Http\Validators\Main\Account\Profile\SocialValidator;
use App\Models\UserAvailability;
use App\Models\UserLanguage;
use App\Models\UserLinkedAccount;
use App\Models\UserSkill;
use App\Utils\Uploader\ImageUploader;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class EditProfile extends Component
{
    use WithFileUploads;
    public $avatar;
    public $headline;
    public $description;

    // Linked accounts
    public $facebook_profile;
    public $twitter_profile;
    public $dribbble_profile;
    public $stackoverflow_profile;
    public $github_profile;
    public $youtube_profile;
    public $vimeo_profile;

    // Skills
    public $skills;
    public $add_skill;

    // Languages
    public $languages;
    public $add_language;

    // Availability
    public $availability;
    public $availability_date;
    public $availability_message;

    // construct
    public function mount()
    {
        // Get user data
        $user               = auth()->user();

        // Get linked accounts
        $linked_accounts    = UserLinkedAccount::firstOrCreate(['user_id' => auth()->id()]);

        // Set user skills
        $this->skills       = auth()->user()->skills()->orderBy('id', 'desc')->get();

        // Set user languages
        $this->languages    = auth()->user()->languages()->orderBy('id', 'desc')->get();

        // Set user availability
        $this->availability = auth()->user()->availability()->first();

        // Set linked accounts
        $this->fill([
            'headline'              => $user->headline,
            'description'           => $user->description,
            'facebook_profile'      => $linked_accounts->facebook_profile,
            'twitter_profile'       => $linked_accounts->twitter_profile,
            'dribbble_profile'      => $linked_accounts->dribbble_profile,
            'stackoverflow_profile' => $linked_accounts->stackoverflow_profile,
            'github_profile'        => $linked_accounts->github_profile,
            'youtube_profile'       => $linked_accounts->youtube_profile,
            'vimeo_profile'         => $linked_accounts->vimeo_profile,
        ]);
    }

    
    public function render()
    {
        return view('livewire.profile.edit-profile')->extends('layouts.myL')->section('main');
    }

    // update avatar image
    public function updatedAvatar()
    {
        try {

            // Validate form
            AvatarValidator::validate($this);

            // Upload avatar
            $id = auth()->user()->avatar_id;
            // Update user avatar
            auth()->user()->update([
                'avatar_id' => null
            ]);
            $avatar_id = ImageUploader::make($this->avatar)
                                      ->resize(100)
                                      ->folder('avatars')
                                      ->deleteById($id)
                                      ->handle();

            // Update user avatar
            auth()->user()->update([
                'avatar_id' => $avatar_id
            ]);
            
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Avatar uploaded']);
            
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }

    /**
     * Update headline
     *
     * @return void
     */
    public function setHeadline()
    {
        try {

            // Validate form
            HeadlineValidator::validate($this);
            // Update user headline
            auth()->user()->update([
                'headline' => strip_tags($this->headline)
            ]);

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" =>'headline updated successfully',
                'type' => 'success'
            ]);

            // Profile updated
            $this->dispatchBrowserEvent('profile-headline-updated');

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }

       /**
     * Update socila media account
     *
     * @return void
     */
    public function updateSocial()
    {
        try {

            // Validate form
            SocialValidator::validate($this);

            // Update user headline
            UserLinkedAccount::where('user_id', auth()->id())->update([
                'facebook_profile'      => strip_tags($this->facebook_profile),
                'twitter_profile'       => strip_tags($this->twitter_profile),
                'dribbble_profile'      => strip_tags($this->dribbble_profile),
                'stackoverflow_profile' => strip_tags($this->stackoverflow_profile),
                'github_profile'        => strip_tags($this->github_profile),
                'youtube_profile'       => strip_tags($this->youtube_profile),
                'vimeo_profile'         => strip_tags($this->vimeo_profile)
            ]);

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" =>   'Accounts has been updated',
                'type' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        } 
    }

    
    /**
     * Add new skill
     *
     * @return void
     */
    public function addSkill()
    {
        try {

            // Validate form
            $this->validate([
                'add_skill.name'       => 'required|max:30',
                'add_skill.experience' => 'required|in:beginner,intermediate,pro'
            ],[
                'add_skill.name.required'       => __('messages.t_validator_required'),
                'add_skill.name.max'            => __('messages.t_validator_max', ['max' => 30]),
                'add_skill.experience.required' => __('messages.t_validator_required'),
                'add_skill.experience.in'       => __('messages.t_validator_in'),
            ]);

            // Check if skill already exists
            $is_exists = UserSkill::where('user_id', auth()->id())->where('name', $this->add_skill['name'])->first();

            if ($is_exists) {
                
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" => 'add skill already exists',
                    "type"    => "error"
                ]);
                
                // Return
                return;

            }

            // Add skill
            UserSkill::create([
                'user_id'    => auth()->id(),
                'name'       => $this->add_skill['name'],
                'slug'       => Str::slug($this->add_skill['name']),
                'experience' => $this->add_skill['experience']
            ]);

            // Refresh list of skills
            $this->skills = auth()->user()->skills()->orderBy('id', 'desc')->get();

            // Reset form
            $this->reset('add_skill');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Skill added to ur profile',
                'type' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }

    /**
     * Delete a skill
     *
     * @param integer $id
     * @return void
     */
    public function deleteSkill($id)
    {
        // Get skill
        UserSkill::where('user_id', auth()->id())->where('id', $id)->delete();

        // Refresh list of skills
        $this->skills = auth()->user()->skills()->orderBy('id', 'desc')->get();

        // Success
        $this->dispatchBrowserEvent('alert',[
            "message" =>  'Skill has been deleted from profile',
            'type' => 'success'
        ]);
    }


    
    /**
     * Edit skill
     *
     * @param integer $id
     * @return void
     */
    public function editSkill($id)
    {
        // Get skill
        $skill = UserSkill::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        // Set skill in edit form
        $this->add_skill['name']       = $skill->name;
        $this->add_skill['experience'] = $skill->experience;
        $this->add_skill['id']         = $skill->id;

        // Open edit form
        $this->dispatchBrowserEvent('open-skills-edit-form');
    }


     /**
     * Update skill
     *
     * @return void
     */
    public function updateSkill()
    {
        try {


            // Validate form
            $this->validate([
                'add_skill.name'       => 'required|max:30',
                'add_skill.experience' => 'required|in:beginner,intermediate,pro'
            ],[
                'add_skill.name.required'       => __('messages.t_validator_required'),
                'add_skill.name.max'            => __('messages.t_validator_max', ['max' => 30]),
                'add_skill.experience.required' => __('messages.t_validator_required'),
                'add_skill.experience.in'       => __('messages.t_validator_in'),
            ]);


            // Check if skill already exists
            $is_exists = UserSkill::where('user_id', auth()->id())
                                  ->where('name', $this->add_skill['name'])
                                  ->where('id', '!=', $this->add_skill['id'])
                                  ->first();

            if ($is_exists) {
                
                
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" => 'add skill already exists',
                    "type"    => "error"
                ]);
                
                // Return
                return;

            }

            // Update skill
            UserSkill::where('id', $this->add_skill['id'])->where('user_id', auth()->id())->update([
                'user_id'    => auth()->id(),
                'name'       => $this->add_skill['name'],
                'slug'       => Str::slug($this->add_skill['name']),
                'experience' => $this->add_skill['experience']
            ]);

            // Refresh list of skills
            $this->skills = auth()->user()->skills()->orderBy('id', 'desc')->get();

            // Reset form
            $this->reset('add_skill');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'skill updated',
                'type' => 'success'
            ]);

            // Close form
            $this->dispatchBrowserEvent('close-edit-skill-form');

        }  catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }


    
    /**
     * Add new language
     *
     * @return void
     */
    public function addLanguage()
    {
        try {

            // Validate form
            $this->validate([
                'add_language.name'  => 'required|max:100',
                'add_language.level' => 'required|in:basic,conversational,fluent,native'
            ],[
                'add_language.name.required'       => __('messages.t_validator_required'),
                'add_language.name.max'            => __('messages.t_validator_max', ['max' => 100]),
                'add_language.experience.required' => __('messages.t_validator_required'),
                'add_language.experience.in'       => __('messages.t_validator_in'),
            ]);


            // Check if language already exists
            $is_exists = UserLanguage::where('user_id', auth()->id())->where('name', $this->add_language['name'])->first();

            if ($is_exists) {
                
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" =>   'add language already exists',
                    "type"    => "error"
                ]);

                // Reload select2
                $this->reloadSelect2();
                
                // Return
                return;

            }

            // Add language
            UserLanguage::create([
                'user_id' => auth()->id(),
                'name'    => $this->add_language['name'],
                'level'   => $this->add_language['level']
            ]);

            // Refresh list of languages
            $this->languages = auth()->user()->languages()->orderBy('id', 'desc')->get();

            // Reset form
            $this->reset('add_language');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'language added to ur profile',
                'type' => 'success'
            ]);

            // Reload select2
            $this->reloadSelect2();

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);


            // Reload select2
            $this->reloadSelect2();

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            // Reload select2
            $this->reloadSelect2();

            throw $th;

        }
    }

    
    /**
     * Delete a language
     *
     * @param integer $id
     * @return void
     */
    public function deleteLanguage($id)
    {
        // Get language
        UserLanguage::where('user_id', auth()->id())->where('id', $id)->delete();

        // Refresh list of languages
        $this->languages = auth()->user()->languages()->orderBy('id', 'desc')->get();

        // Success
        $this->dispatchBrowserEvent('alert',[
            "message" => 'language has been deleted from profile',
            'type' => 'success'
        ]);

        // Reload select2
        $this->reloadSelect2();
    }


    /**
     * Edit language
     *
     * @param integer $id
     * @return void
     */
    public function editLanguage($id)
    {
        // Get language
        $language = UserLanguage::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        // Set language in edit form
        $this->add_language['name']  = $language->name;
        $this->add_language['level'] = $language->level;
        $this->add_language['id']    = $language->id;

        // Open edit form
        $this->dispatchBrowserEvent('open-languages-edit-form');

        // Reload select2
        $this->reloadSelect2();
    }


    /**
     * Update language
     *
     * @return void
     */
    public function updateLanguage()
    {
        try {

            // Validate form
            $this->validate([
                'add_language.name'  => 'required|max:100',
                'add_language.level' => 'required|in:basic,conversational,fluent,native'
            ],[
                'add_language.name.required'       => __('messages.t_validator_required'),
                'add_language.name.max'            => __('messages.t_validator_max', ['max' => 100]),
                'add_language.experience.required' => __('messages.t_validator_required'),
                'add_language.experience.in'       => __('messages.t_validator_in'),
            ]);

            // Check if language already exists
            $is_exists = UserLanguage::where('user_id', auth()->id())
                                  ->where('name', $this->add_language['name'])
                                  ->where('id', '!=', $this->add_language['id'])
                                  ->first();

            if ($is_exists) {
                
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" =>   'add language already exists',
                    "type"    => "error"
                ]);

                // Reload select2
                $this->reloadSelect2();
                
                // Return
                return;

            }

            // Update language
            UserLanguage::where('id', $this->add_language['id'])->where('user_id', auth()->id())->update([
                'user_id' => auth()->id(),
                'name'    => $this->add_language['name'],
                'level'   => $this->add_language['level']
            ]);

            // Refresh list of languages
            $this->languages = auth()->user()->languages()->orderBy('id', 'desc')->get();

            // Reset form
            $this->reset('add_language');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'language updated',
                'type' => 'success'
            ]);

            // Close form
            $this->dispatchBrowserEvent('close-edit-language-form');

            // Reload select2
            $this->reloadSelect2();

        }  catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);


            // Reload select2
            $this->reloadSelect2();

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            // Reload select2
            $this->reloadSelect2();

            throw $th;

        }
    }


    /**
     * Reload select2
     *
     * @return void
     */
    public function reloadSelect2()
    {
        // Reload select2
        $this->dispatchBrowserEvent('pharaonic.select2.load', [
            'target'    => '.select2',
            'component' => $this->id
        ]);
    }


    /**
     * Update user description
     *
     * @return void
     */
    public function updateDescription()
    {
        try {
            
            // Validate form
            DescriptionValidator::validate($this);
           

            // Update description
            auth()->user()->update([
                'description' => $this->description
            ]);

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Profile description updated',
                'type'=>'success'
            ]);

            // Close form
            $this->dispatchBrowserEvent('close-description-edit-form');

        } catch (\Illuminate\Validation\ValidationException $e) {

            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Throwable $th) {

            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }

    /**
     * Set Availability
     *
     * @return void
     */
    public function setAvailability()
    {
        try {

            // Only for sellers
            if (auth()->user()->account_type !== 'seller') {
                return;
            }

            // Validate form
            AvailabilityValidator::validate($this);

            // Set end date
            $availability_date = Carbon::create($this->availability_date);

            // Check if date in future
            if (!$availability_date->isFuture()) {
                
                // Error
                $this->dispatchBrowserEvent('alert',[
                    "message" => 'Please select availability date in future',
                    "type"    => "error"
                ]);

                return;

            }

            // Delete old availability
            auth()->user()->availability()->delete();

            // Update availability
            $availability = UserAvailability::create([
                'user_id'                 => auth()->id(),
                'message'                 => $this->availability_message ? strip_tags($this->availability_message) : null,
                'expected_available_date' => $availability_date->toDateTimeString()
            ]);

            // Set user availability
            $this->availability = $availability;
            $this->availability_date = null;
            $this->availability_message = null;
            // Close modal
            $this->dispatchBrowserEvent('close-modal', 'modal-set-availability-container');

            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Your availability settings updated',
                'type'=>'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            
            // Validation error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'form validation error',
                "type"    => "error"
            ]);

            throw $e;

        } catch (\Carbon\Exceptions\InvalidFormatException $e) {

            // Invalid date format
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Invalid date format',
                "type"    => "error"
            ]);

            return;

        } catch (\Throwable $th) {

           // Error
           $this->dispatchBrowserEvent('alert',[
                "message" => 'something went wrong',
                "type"    => "error"
            ]);

            throw $th;

        }
    }


    /**
     * Delete user availability
     *
     * @return void
     */
    public function removeAvailability()
    {
        // Check if user has availability
        if ($this->availability) {
            $this->availability->delete();
            $this->availability = null;
            $this->dispatchBrowserEvent('refresh');
        }
    }
    


}
