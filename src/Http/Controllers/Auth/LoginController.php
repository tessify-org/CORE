<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function getLogin()
    {
        // Render the login page
        return view("tessify-core::pages.auth.login", [
            "oldInput" => collect([
                "email" => old("email"),
            ])
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
        // Attempt to login using the received credentials
        if (!Auth::attempt(["email" => $request->email, "password" => $request->password]))
        {
            flash(__("tessify-core::auth.login_password_incorrect"))->error();
            return redirect()->route("auth.login");
        }

        // Grab the user we just logged in as
        $user = User::where("email", $request->email)->first();
        
        // Flash a success message
        flash(__("tessify-core::auth.login_welcome_back", ['name' => $user->formattedName]))->success();

        // If we were trying to go somewhere before logging in, go there now we are
        if (session()->has("redirect_after_login"))
        {
            $intended = session("redirect_after_login");
            session()->forget("redirect_after_login");
            return redirect($intended);
        }

        // Otherwise redirect the user to their dashboard
        return redirect()->route("dashboard");
    }
}