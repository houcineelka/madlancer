<?php

namespace App\Http\Livewire\Profile;

use App\Http\Validators\Main\Profile\ReportValidator;
use App\Models\ReportedUser;
use Livewire\Component;

class ReportProfile extends Component
{
    public $reason;
    public $user;
    public function mount($user)
    {
        $this->user = $user;
    }
    public function report()
    {
        // User must be online
        if (auth()->guest()) {
                
            // Error
            $this->dispatchBrowserEvent('alert',[
                "message" => 'You must login to report this profile',
                "type"    => "info"
            ]);

            return;

        }

        // Can't report your own profile
        if (auth()->id() === $this->user->id) {
            return;
        }
        ReportValidator::validate($this);
            ReportedUser::updateOrCreate(
                ['reporter_id' => auth()->id(), 'reported_id' => $this->user->id],
                [
                    'ip_address' => request()->ip(),
                    'reason'     => strip_tags($this->reason),
                    'seen'       => false
                ]
            );
            // notify admin
            // code===================
            // Success
            $this->dispatchBrowserEvent('alert',[
                "message" => 'Profile has been successfully reported',
            ]);
    }
    public function render()
    {
        return view('livewire.profile.report-profile');
    }
}
