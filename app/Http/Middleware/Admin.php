<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->role_user()->user_id == 4) {
                return $next($request);
            } else {
                return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
        return redirect('/login')->with('error', 'Silakan login untuk mengakses halaman ini.');
        
    }
}
