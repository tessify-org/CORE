<?php

namespace Tessify\Core\Http\Requests\Profiles;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            "first_name" => "required",
            "last_name" => "required",
            "headline" => "nullable",
            "interests" => "nullable",
            "email" => "required|email|unique:users,email,".Auth::user()->id,
            "phone" => "nullable",
            "current_assignment_id" => "nullable|exists:assignments,id",
            "skills" => "nullable",
            "avatar" => "nullable|image",
            "header_bg" => "nullable|image",
        ];
    }

    public function messages()
    {
        return [];
    }
}
