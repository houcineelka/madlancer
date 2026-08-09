<?php

namespace App\Http\Livewire\Auth;

use App\Http\Validators\Main\Account\Profile\AddLanguageValidator;
use App\Http\Validators\Main\Account\Profile\AddSkillValidator;
use App\Http\Validators\Main\Account\Profile\AvatarValidator;
use App\Models\FileManager;
use App\Models\Language;
use App\Models\UserLanguage;
use App\Models\UserSkill;
use App\Utils\Uploader\ImageUploader;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Str;

class CompleteRegisterStep2 extends Component
{
    use WithFileUploads;

    public $avatar;
    public $languages ;
    public $isAddLanguage = false;
    public $isAddSkill = false;
    public $add_language_level;
    public $add_language_name;
    public $add_skill_experience;
    public $add_skill_name;

    public $goBack = false;

    public function mount()
    {
        $this->languages = Language::all();
    }

    public function goBack()
    {
        $this->goBack = true;
    }

    public function newLang()
    {
        $this->isAddLanguage = !$this->isAddLanguage;
        
    }
    
    public function newSkill()
    {
        $this->isAddSkill = !$this->isAddSkill;
        
    }

    public function addAvatar()
    {
        
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
        
    }
    

    
    public function removeLang($name)
    {
        UserLanguage::where('user_id', auth()->id())->where('name', $name)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Language removed']);
    }

    
    public function removeSkill($name)
    {
        UserSkill::where('user_id', auth()->id())->where('name', $name)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Skill removed']);
    }
    
    public function addLang()
    {
        AddLanguageValidator::validate($this);
            $is_exists = UserLanguage::where('user_id', auth()->id())->where('name', $this->add_language_name)->first();
            if (!$is_exists) {
                // Add language
                UserLanguage::create([
                    'user_id' => auth()->id(),
                    'name'    => $this->add_language_name,
                    'level'   => $this->add_language_level
                ]);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Language added']);
                $this->reset('add_language_name');
                $this->reset('add_language_level');
            }else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Language already exists']);
            }

    }
    public function addSkill()
    {
        AddSkillValidator::validate($this);
            $is_exists = UserSkill::where('user_id', auth()->id())->where('name', $this->add_skill_name)->first();
            if (!$is_exists) {
                // Add skill
                UserSkill::create([
                    'user_id' => auth()->id(),
                    'name'    => $this->add_skill_name,
                    'slug'    => Str::slug($this->add_skill_name),
                    'experience'   => $this->add_skill_experience
                ]);
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Skill added']);
                $this->reset('add_skill_name');
                $this->reset('add_skill_experience');
            }else {
                $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Skill already exists']);
            }

    }


    public function completeRegistration()
    {
        if (auth()->user()->languages->count() && (auth()->user()->skills->count() || auth()->user()->account_type == 'buyer')) {
            if (auth()->user()->account_type == 'seller') {
                return redirect('/create/gig')->with([
                    'success'=>'Your account has been completed',
                    'status'=>'You can now publish your first Gig',
    
                ]);
            } else {
                return redirect('/create/job')->with([
                    'success'=>'Your account has been completed',
                    'status'=>'You can now publish your first job post',
    
                ]);
            }
        } else {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Please complete your informations']);
        }
        
       
        
    }


    public function render()
    {
        return view('livewire.auth.complete-register-step2');
    }
}
