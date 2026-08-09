<?php

namespace App\Http\Middleware;

use App\Models\PasswordReset;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class time
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $email=request('email');
        $token=request('token');
        // $expires = request('expires'); 
        $verify = PasswordReset::where('email', $email)->where('token', $token)->first();

        if (!$verify) {
            return redirect('/expired');
        }
        $time = new Carbon($verify->expires_at);

            if(!auth()->check()){
                if(!$time->isPast()){
                    return $next($request);
                }
            }
        
        return redirect('/expired');
    }
}
