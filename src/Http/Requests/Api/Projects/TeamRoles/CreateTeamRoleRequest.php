<?php

namespace Tessify\Core\Http\Requests\Api\Projects\TeamRoles;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeamRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "project_id" => "required|exists:projects,id",
            "name" => "required",
            "description" => "required",
            "positions" => "required|integer",
        ];
    }
}
