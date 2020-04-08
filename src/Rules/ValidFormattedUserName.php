<?php

namespace Tessify\Core\Rules;

use Users;
use Illuminate\Contracts\Validation\Rule;

class ValidFormattedUserName implements Rule
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
        return Users::userWithFormattedNameExists($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __("tessify-core::messages.invalid_user");
    }
}
