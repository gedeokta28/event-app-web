<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $price = 10_000;

        return [
            'stockname'     => $this->faker->userName(),
            'barcode'       => $this->faker->userName(),
            'brandid'       => $this->faker->safeColorName(),
            'categoryid'    => $this->faker->userName(),
            'hrg1'          => $price,
            'disclist1'     => 42.5,
            'hrg2'          => $price,
            'disclist2'     => 45,
            'hrg3'          => $price,
            'disclist3'     => 47.5,
            'qty1'          => 1,
            'qty2'          => 10,
            'qty3'          => 100,
            'berat'         => 700,
            'discountinued' => false,
            'stockdescription' => $this->faker->paragraph(5),
            'satuanunit'    => 'pcs'
        ];
    }
}
