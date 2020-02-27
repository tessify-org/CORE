<?php

namespace Tessify\Core\Http\Requests\Ministries;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateMinistryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "abbreviation" => "nullable",
            "description" => "nullable",
            "website_url" => "nullable",
            "logo_url" => "nullable|image"
        ];
    }
}
