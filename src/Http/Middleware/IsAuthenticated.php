<?php

namespace Tessify\Core\Http\Middleware;

use Auth;
use Closure;

class IsAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check())
        {
            session()->put("redirect_after_login", $request->url());

            flash(__('tessify-core::auth.middleware_login_required'))->error();
            return redirect()->route("auth.login");
        }
    
        return $next($request);
    }
}