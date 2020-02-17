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

        ];
    }

    public function messages()
    {
        return [];
    }
}
