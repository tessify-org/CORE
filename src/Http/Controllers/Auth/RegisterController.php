<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Auth;
use App\Models\User;
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
        $user = User::create([
            "annotation" => $request->annotation,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => $request->password,
        ]);
        
        Auth::login($user);
        
        flash(__('tessify-core::auth.register_success'))->success();
        return redirect()->route("home");
    }
}