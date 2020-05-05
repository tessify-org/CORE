<?php

namespace Tessify\Core\Http\Requests\Projects;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectResourcesRequest extends FormRequest
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
            "resources" => "required",
        ];
    }
}
