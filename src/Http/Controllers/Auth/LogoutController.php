<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Auth;
use Tessify\Core\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function getLogout()
    {
        Auth::logout();
        
        flash(__("tessify-core::auth.logout_cya_later"))->success();
        return redirect()->route("home");
    }
}