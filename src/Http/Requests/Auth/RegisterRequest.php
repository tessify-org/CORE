<?php

namespace Tessify\Core\Http\Requests\Auth;

use Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "annotation" => "required",
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed",
            "password_confirmation" => "required",
        ];
    }
}