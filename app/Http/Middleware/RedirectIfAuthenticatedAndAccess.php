<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedAndAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $permission = config("permission");
        if (Auth::check() && Auth::user()->{$permission[$guard]}) {
            return $next($request);
        }

        return abort(202,__("You dont have access"));
    }
}
