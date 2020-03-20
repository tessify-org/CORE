<?php

namespace Tessify\Core\Http\Requests\BugReports;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SubmitBugReportRequest extends FormRequest
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
            "url" => "required",
            "severity" => "required",
            "report" => "required",
        ];
    }
}
