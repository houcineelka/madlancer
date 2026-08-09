<?php

namespace App\Http\Livewire;

use App\Mail\updateMail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class UpdatePassword extends Component
{
    public $password;
    public $password_confirmation;
    public $email;
    public $token;
    protected $queryString = ['email', 'token'];


    public function render()
    {
        return view('livewire.update-password');
    }
    public function update(){

        $verify = PasswordReset::where('email', $this->email)->where('token', $this->token)->first();


        $rules    = $this->validate([
            'password' => 'required|max:60',
            'password_confirmation'=> 'required|max:60',
        ]);
        if($this->password==$this->password_confirmation){
        $user = User::where('email', $this->email)->first();
        
        $user->password = Hash::make($this->password);
        $user->save();

        $verify->delete();

        Mail::to($this->email)->send(new updateMail());
        // session()->flash('success','password not corect');
        // Success
               
            return redirect('/');
    }else{
            session()->flash('pass','password not corect');
        }
    }
}
