<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Auth;
use Users;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function getRegister()
    {
        return view("tessify-core::pages.auth.register", [
            "oldInput" => collect([
                "annotation" => old("annotation"),
                "first_name" => old("first_name"),
                "last_name" => old("last_name"),
                "email" => old("email"),
            ])
        ]);
    }

    public function postRegister(RegisterRequest $request)
    {
        $user = Users::createFromRegisterRequest($request);
        
        Auth::login($user);
        
        flash(__('tessify-core::auth.register_success'))->success();
        return redirect()->route("home");
    }
}