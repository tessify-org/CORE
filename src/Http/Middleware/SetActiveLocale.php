<?php

namespace Tessify\Core\Http\Middleware;

use Auth;
use Closure;

class SetActiveLocale
{
    public function handle($request, Closure $next)
    {
        if (!is_null($request->session()->get('active_locale')))
        {
            app()->setLocale($request->session()->get('active_locale'));
        }

        return $next($request);
    }
}