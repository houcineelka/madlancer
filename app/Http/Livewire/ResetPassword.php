<?php

namespace App\Http\Livewire;

use App\Mail\resetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ResetPassword extends Component

{
    public $email;

    function uid($length = 20)
    {
        $bytes  = random_bytes($length);
        $random = bin2hex($bytes);
        return strtoupper(substr($random, 0, $length));
    }
    public function send(){
        $rules    = $this->validate([
            'email'    => 'required|max:60|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
        ]);
        $user= User::where('email', $this->email)
                ->whereIn('status', ['active', 'verified'])
                ->whereNotNull('password')
                ->first();

                if ($user) {
                PasswordReset::where('email', $user->email)->delete();

                $token             = $this->uid(64);
                $reset             = new PasswordReset();
                $reset->token      = $token;
                $reset->email      = $this->email;
                $reset->expires_at = now()->addMinutes(10);
                $reset->save();

                $tb=[$reset];

                    Mail::to($this->email)->send(new resetMail($tb));
                    
                    session()->flash('success','check your email to reset password');
                    return redirect('/');
                    
                }else{

                session()->flash('error','email not found');
            }
    

    }
    public function render(){
        return view('livewire.reset-password');
    }

    
}
