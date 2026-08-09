<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationCompleteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->country && auth()->user()->headline && auth()->user()->description && auth()->user()->languages->count()) {
            if (auth()->user()->account_type == 'buyer' || auth()->user()->skills->count()) {
                return redirect()->route('home')->with('status','Your account already completed. ');
            }
        }
        return $next($request);
    }
}
