<?php

namespace Tessify\Core\Http\Requests\Api\Projects\Resources;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateProjectResourceRequest extends FormRequest
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
            "job_id" => "nullable|exists:jobs,id",
            "title" => "required",
            "description" => "",
            "file" => "required|file"
        ];
    }
}
