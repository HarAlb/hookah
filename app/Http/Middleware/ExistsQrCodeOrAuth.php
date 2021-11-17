<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExistsQrCodeOrAuth
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
        if(auth()->user() || $request->has('qr_code')){
            return $next($request);
        }
        return route('login');
    }
}
