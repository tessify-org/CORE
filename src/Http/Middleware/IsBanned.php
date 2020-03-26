<?php

namespace Tessify\Core\Http\Middleware;

use Auth;
use Closure;

class IsBanned
{
    public function handle($request, Closure $next)
    {
        // Bans only apply if the user is logged in
        if (Auth::check())
        {
            // Grab the logged in user
            $user = Auth::user();

            // If the user has been perma banned
            if ($user->permabanned)
            {
                // Logout the user
                Auth::logout();

                // Redirect + flash message
                flash(__('tessify-core::auth.middleware_banned_permanently'))->error();
                return redirect()->route("auth.login");
            }
            // If the user has been temp banned
            else if ($user->banned_until)
            {
                // If user is not banned permanently and the ban has not expired
                if (now()->lessThan($user->banned_until))
                {
                    // Logout the user
                    Auth::logout();

                    // Determine the amount of days the ban will be active for
                    $numDays = now()->diffInDays($user->banned_until);

                    // Determine what word to use for the "days" part in the flash message string
                    $dayString = $numDays == 1 
                        ? __('tessify-core::auth.middleware_banned_temporarily_day') 
                        : __('tessify-core::auth.middleware_banned_temporarily_days');

                    // Redirect + flash message
                    flash(__('tessify-core::auth.middleware_banned_temporarily', ['days' => $numDays, 'day' => $dayString]))->error();
                    return redirect()->route("auth.login");
                }
                // If the user is not banned permanently and the ban has expired
                else
                {
                    // Lift the ban
                    $user->banned_until = null;
                    $user->save();
                    
                    // Redirect + flash message
                    flash(__('tessify-core::auth.middleware_ban_lifted'))->error();
                    return redirect()->route("home");
                }
            }
        }
        
        return $next($request);
    }
}