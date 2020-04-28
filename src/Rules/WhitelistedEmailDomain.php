<?php

namespace Tessify\Core\Rules;

use Setting;
use WhitelistedDomains;
use Illuminate\Contracts\Validation\Rule;

class WhitelistedEmailDomain implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (Setting::has("whitelisted_domains_enabled") && Setting::get("whitelisted_domains_enabled") == "true")
        {
            return WhitelistedDomains::emailIsWhitelisted($value);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("tessify-core::auth.register_invalid_email_domain");
    }
}
