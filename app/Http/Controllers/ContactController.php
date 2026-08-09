<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //

    public function index(){
        return view('contact.contact');
    }
    public function send(Request $r){
        Mail::to('madlancer@support')->send(new ContactMail($r->name,$r->email,$r->subject,$r->message));
        session()->flash('success',"your message are send to support");
        return redirect()->to('/');
    }

}

