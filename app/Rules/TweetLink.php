<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TweetLink implements Rule
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
        return boolval(preg_match('/http(?:s)?:\/\/(?:www\.)?twitter\.com\/[a-zA-Z0-9_]+\/status\/[0-9]+/', $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid tweet URL';
    }
}
