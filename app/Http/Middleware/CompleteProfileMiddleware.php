<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompleteProfileMiddleware
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
                return $next($request);
            }
        }
        return redirect()->route('afterRegister')->with('warning','Please complete your account before. ');
        
    }
}
