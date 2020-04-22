<?php

namespace Tessify\Core\Http\Middleware;

use Closure;

class CheckForOldBrowsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the user is browsing the web using Internet Explorer
        $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
        if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false))
        {
	        return redirect()->route("system.dont-use-ie");
        }

        return $next($request);
    }
}
