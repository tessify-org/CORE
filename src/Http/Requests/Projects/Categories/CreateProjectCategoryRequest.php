<?php

namespace Tessify\Core\Http\Requests\Projects\Categories;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectCategoryRequest extends FormRequest
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
            "label" => "required",
        ];
    }
}
