<?php

namespace App\Http\Controllers;

use App\Mail\NewsVerification;
use App\Models\NewsletterList;
use App\Models\NewsletterVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
   
    
}
