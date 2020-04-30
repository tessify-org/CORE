<?php

namespace Tessify\Core\Http\Requests\Tasks;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            "project_id" => "nullable|exists:projects,id",
            "ministry_id" => "nullable|exists:ministries,id",
            "organization_id" => "nullable|exists:organizations,id",
            "department" => "nullable",
            "task_category" => "required",
            "task_status_id" => "required|exists:task_statuses,id",
            "task_seniority_id" => "required|exists:task_seniorities,id",
            "title" => "required",
            "description" => "required",
            "complexity" => "required|integer",
            "estimated_hours" => "required|integer",
            "urgency" => "required|integer",
            "required_skills" => "nullable",
            "tags" => "nullable",
        ];
    }
}
