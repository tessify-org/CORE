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
        return view("tessify-core::pages.auth.login", [
            "oldInput" => collect([
                "email" => old("email"),
            ])
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
        if (!Auth::attempt(["email" => $request->email, "password" => $request->password]))
        {
            flash(__("tessify-core::auth.login_password_incorrect"))->error();
            return redirect()->route("auth.login");
        }
        
        $user = User::where("email", $request->email)->first();
        
        flash(__("tessify-core::auth.login_welcome_back", ['name' => $user->formattedName]))->success();
        return redirect()->route("home");
    }
}