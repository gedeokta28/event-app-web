<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesOrderDetail>
 */
class SalesOrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'stockid'           => uniqid(),
            'stockname'         => $this->faker->jobTitle(),
            'qtyorder'          => 100,
            'price'             => rand(1000, 9999),
            'discountpercent'   => 10,
            'discountamount'    => 10,
            'netprice'          => 1000,
            'nettotal'          => 1000
        ];
    }
}
