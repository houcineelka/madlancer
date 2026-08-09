<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class AfterRegisterController extends Controller
{
    public function index()
    {
        $data['countries']= Country::all();
        return view('auth.complete-register',$data);
    }
}
