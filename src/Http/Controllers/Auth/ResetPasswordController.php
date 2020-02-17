<?php

namespace Tessify\Core\Http\Controllers\Auth;

use Users;
use Exception;

use App\Http\Controllers\Controller;
use Tessify\Core\Http\Requests\Auth\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function getResetPassword($email, $code)
    {
        try
        {
            // Validate the email address manually
            if (!Users::emailExists($email)) throw new Exception(__('tessify-core::auth.reset_password_error_invalid_email'));

            // Validate the recovery code manually
            if (!Users::recoveryCodeIsValid($email, $code)) throw new Exception(__('tessify-core::auth.reset_password_error_invalid_code'));
        }
        catch (Exception $e)
        {
            flash($e->getMessage())->error();
            return redirect()->route("auth.login");
        }

        return view("tessify-core::pages.auth.reset-password", [
            "email" => $email,
            "code" => $code,
        ]);
    }

    public function postResetPassword(ResetPasswordRequest $request, $email, $code)
    {
        try
        {
            // Validate the email address manually
            if (!Users::emailExists($email)) throw new Exception(__('tessify-core::auth.reset_password_error_invalid_email'));

            // Validate the recovery code manually
            if (!Users::recoveryCodeIsValid($email, $code)) throw new Exception(__('tessify-core::tessify-core::auth.reset_password_error_invalid_code'));

            // Grab the user
            $user = Users::findUserByEmail($email);

            // Reset password
            $user = Users::resetPassword($user, $request);

            // Redirect to login
            flash(__('tessify-core::auth.reset_password_success'))->success();
            return redirect()->route("auth.login");
        }
        catch (Exception $e)
        {
            flash($e->getMessage())->error();
            return redirect()->route("auth.login");
        }
    }
}