<?php

namespace Tessify\Core\Http\Requests\Tasks;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            "project_id" => "nullable",
            "task_category" => "required",
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
