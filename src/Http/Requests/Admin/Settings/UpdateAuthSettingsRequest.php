<?php

namespace Tessify\Core\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() and auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "whitelisted_domains" => "required",
            "email_activation_required" => "required",
            "whitelisted_domains_enabled" => "required",
        ];
    }
}
