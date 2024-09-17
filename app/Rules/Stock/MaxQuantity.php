<?php

namespace App\Rules\Stock;

use Illuminate\Contracts\Validation\Rule;

class MaxQuantity implements Rule
{

    private $stockid;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stockid)
    {
        $this->stockid = $stockid;
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
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
