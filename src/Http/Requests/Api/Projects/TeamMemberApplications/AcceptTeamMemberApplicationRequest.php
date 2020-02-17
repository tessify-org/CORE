<?php

namespace Tessify\Core\Http\Requests\Api\Projects\TeamMemberApplications;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class AcceptTeamMemberApplicationRequest extends FormRequest
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
            "team_member_application_id" => "required|integer|exists:team_member_applications,id",
        ];
    }
}
