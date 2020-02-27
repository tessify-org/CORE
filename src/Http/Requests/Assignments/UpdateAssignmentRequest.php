<?php

namespace Tessify\Core\Http\Requests\Assignments;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
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
            "assignment_type_id" => "required|exists:assignment_types,id",
            "organization_id" => "required|exists:organizations,id",
            "organization_department_id" => "required|exists:organization_departments,id",
            "title" => "required",
            "current" => "required",
            "start_date" => "required",
            "end_date" => "nullable",
        ];
    }
}
