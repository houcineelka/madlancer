<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class LoginModal extends Component
{
    public $email;
    public $password;
    public $remember_me = true;
    
    public function verify()
    {
        $rules    = $this->validate([
            'email'    => 'required|max:60|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'password' => 'required|max:60'
        ]);
        

        
        $donnees = ['email' => $this->email, 'password' => $this->password];

        #authCheck and authUser('utiliser model user')
        if (Auth::attempt($donnees, $this->remember_me)) {

            if (Auth::user()->status === 'banned') {
                Auth::logout();
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'your account has been banned']);
                return;
            }

            return redirect(url()->previous());
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'informations are not correct']);
        
        
    }
    public function render()
    {
        return view('livewire.login-modal');
        
    }
}
