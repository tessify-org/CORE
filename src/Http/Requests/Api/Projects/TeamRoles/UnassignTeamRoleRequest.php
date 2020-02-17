<?php

namespace Tessify\Core\Http\Requests\Api\Projects\TeamRoles;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UnassignTeamRoleRequest extends FormRequest
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
            "team_role_id" => "required|integer|exists:team_roles,id",
        ];
    }
}
