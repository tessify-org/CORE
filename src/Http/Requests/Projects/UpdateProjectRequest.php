<?php

namespace Tessify\Core\Http\Requests\Projects;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            "project_status_id" => "required|exists:project_statuses,id",
            "project_category" => "required",
            "project_phase" => "nullable",
            "ministry_id" => "nullable|exists:ministries,id",
            "work_method_id" => "nullable|exists:work_methods,id",
            "title" => "required",
            "slogan" => "nullable",
            "description" => "required",
            "starts_at" => "nullable",
            "ends_at" => "nullable",
            "header_image" => "nullable|image",
            "resources" => "nullable",
            "team_roles" => "nullable",
            "has_deadline" => "required",
            "project_code" => "nullable",
            "budget" => "nullable",
        ];
    }
}
