<?php

namespace App\Http\Livewire;

use App\Mail\NewsVerification;
use App\Models\NewsletterList;
use App\Models\NewsletterVerification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class NewsComponent extends Component
{
    public $email;
    public function render()
    {
        return view('livewire.news-component');
    }
     function uid($length = 20)
    {
        $bytes  = random_bytes($length);
        $random = bin2hex($bytes);
        return strtoupper(substr($random, 0, $length));
    }
    public function news(){

        // validate email
        $rules    = $this->validate([
            'email'    => 'required|max:60|email',
        ]);
     

        // search this email in database
        $email = NewsletterList::where('email', $this->email)->first();

        // Check if email exists
        if ($email) {
            
            // Check if email already verified
            if ($email->status === 'verified') {

                $this->dispatchBrowserEvent('alert', ['type' => 'info',  'message' => 'Your email already in list of newsletter']);

                $this->reset('email');
               

            } else {

                // Delete old verifications
                NewsletterVerification::where('list_id', $email->id)->delete();

                // Generate verification token
                $token = $this->uid(60);

                // Generate verification
                $verification          = new NewsletterVerification();
                $verification->list_id = $email->id;
                $verification->token   = $token;
                $verification->save();

                // Send verification to email
                Mail::to($this->email)->send(new NewsVerification($token));

                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'we sent verification link newsletter to your email']);
                
                $this->reset('email');

            }

        } else {

            // Add email to database
            $list                  = new NewsletterList();
            $list->uid             = $this->uid();
            $list->email           = $this->email;
            $list->ip_address      = request()->ip();
            $list->save();

            //  generate  token
            $token                 = $this->uid(60);

            // Generate verification
            $verification          = new NewsletterVerification();
            $verification->list_id = $list->id;
            $verification->token   = $token;
            $verification->save();

            // Send verification to email
            Mail::to($this->email)->send(new NewsVerification($token));

            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'we sent verification link newsletter to your email']);

            $this->reset('email');
        }
    }
}
