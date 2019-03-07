<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    const ROLE_ADMIN = 1;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == self::ROLE_ADMIN) {
            return $next($request);
        }

        abort(404);
    }
}
