<?php

namespace Tessify\Core\Http\Requests\Api\Projects\Resources;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UploadFilesRequest extends FormRequest
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
            "files.*" => "required|mimes:jpg,jpeg,png,png,svg,doc,docx,pdf|max:20000"
        ];
    }
}
