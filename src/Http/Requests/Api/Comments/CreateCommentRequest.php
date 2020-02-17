<?php

namespace Tessify\Core\Http\Requests\Api\Comments;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            "target_type" => "required",
            "target_id" => "required|integer",
            "comment" => "required|string",
        ];
    }
}
