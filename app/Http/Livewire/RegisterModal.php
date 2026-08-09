<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class RegisterModal extends Component
{
    public $type;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_confirmation;


    public function store()
    {
        $valid = $this->validate([
            "type"=>"required",
            "first_name"=>"required|max:255",
            "last_name"=>"required|max:255",
            "email"=>"required|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users",
            "password"=>"required|confirmed|min:8",
            'password_confirmation' => 'required|same:password'
        ]);
        $user = User::create([
            "uid"=>uniqid(),
            "username"=>$this->first_name.$this->last_name.uniqid(),
            "fullname"=>$this->first_name.' '.$this->last_name,
            "account_type"=>$this->type,
            "email"=>$this->email,
            "level_id"=>$this->type='buyer'?1:2,
            // cryptage de mot de passe
            "password"=>Hash::make($this->password),
        ]);
        if ($user) {
            
            // notify admin
            // code===================
            // authentification
            $donnees = ['email' => $this->email, 'password' => $this->password];
            if (Auth::attempt($donnees)){
                event(new Registered($user));
                session()->flash('success','Welcome to our family. '.$user->fullname);
                session()->flash('warning',' Please check your email '.$user->email.' inbox (and spam folder, just in case!) for a verification email from us.');
                return redirect()->intended('/');
            }
        }
        session()->flash('error','something is wrong, please try again.');
       


    }

    public function render()
    {
        return view('livewire.register-modal');
    }
}
