<?php

namespace Tessify\Core\Http\Requests\Api\Projects\TeamMembers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamMemberRequest extends FormRequest
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
            "team_member_id" => "required|integer|exists:team_members,id",
            "role_ids" => "required",
        ];
    }
}
