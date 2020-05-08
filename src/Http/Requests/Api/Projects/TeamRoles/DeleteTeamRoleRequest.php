<?php

namespace Tessify\Core\Http\Requests\Api\Projects\TeamRoles;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTeamRoleRequest extends FormRequest
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
            "team_role_id" => "required|exists:team_roles,id",
        ];
    }
}
