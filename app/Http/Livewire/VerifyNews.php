<?php

namespace App\Http\Livewire;

use App\Mail\NewsletterApproved;
use App\Models\NewsletterVerification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VerifyNews extends Component
{
    public $token;
    protected $queryString = [
        'token' => ['as' => 'id']
    ];
    public function mount()
    {
        
        $verification = NewsletterVerification::where('token', $this->token)->first();

        if (!$verification) {
            return redirect('/');
        }

        // change status after verify
        $verification->list->update([
            'status' => "verified"
        ]);

        // Send a message say you are approved
        Mail::to($verification->list->email)->send(new NewsletterApproved);

        // Delete verification
        $verification->delete();

        // Success
        session()->flash('success',"you are approved to send any news thank you");
        return redirect('/');
    }
}
