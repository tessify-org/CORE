<?php

namespace Tessify\Core\Http\Middleware;

use Auth;
use Closure;

class IsGuest
{
    public function handle($request, Closure $next)
    {
        if (Auth::check())
        {
            flash(__('tessify-core::auth.middleware_guest_required'))->error();
            return redirect()->route("home");
        }
    
        return $next($request);
    }
}