<?php

namespace Tessify\Core\Http\Requests\Api\Assignments;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssignmentRequest extends FormRequest
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
            "assignment_type_id" => "required|integer|exists:assignment_types,id",
            "organization" => "required",
            "organization_location_id" => "nullable",
            "department" => "required",
            "title" => "required",
            "current" => "required",
            "start_date" => "required",
            "end_date" => "nullable",
        ];
    }
}
