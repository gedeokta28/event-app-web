<?php

namespace App\Rules\ProductVariant;

use Illuminate\Contracts\Validation\Rule;

class ProductVariantConstrain implements Rule
{

    private $stockid;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stockid = null)
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
        if ($this->stockid) {
            return \App\Models\Stock::where('stockid', $value)->where('stockid', $this->stockid)->exists();
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
        return 'Product variant not found.';
    }
}
