<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Users;
use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Auth\ForgotPasswordRequest;

class ForgotPasswordController extends Controller
{
    public function getForgotPassword()
    {
        return view("tessify-core::pages.auth.forgot-password");
    }

    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        Users::sendRecoverAccountEmail($request->email);

        return view("tessify-core::pages.auth.forgot-password-email-sent", [
            "email" => $request->email
        ]);
    }
}