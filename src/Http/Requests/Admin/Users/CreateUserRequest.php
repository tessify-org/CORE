<?php

namespace Tessify\Core\Http\Requests\Admin\Users;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() and Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "first_name" => "",
            "last_name" => "required",
            "email" => "required|unique:users,email",
            "password" => "required|confirmed",
            "password_confirmation" => "required",
        ];
    }
}
