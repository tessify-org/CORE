<?php

namespace Tessify\Core\Http\Requests\Organizations;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
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
            "ministry_id" => "nullable|exists:ministries,id",
            "name" => "required",
            "abbreviation" => "nullable",
            "description" => "nullable",
            "wesite_url" => "nullable",
            "logo" => "nullable|image",
        ];
    }
}
