<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductImageMax implements Rule
{

    private $stock;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stockid)
    {
        $this->stock = \App\Models\Stock::find($stockid);
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
        return $this->stock->images->count() < config('services.product_images.max');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf("Max image uploads exceeded (max: %d)", config('services.product_images.max'));
    }
}
