<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SalesOrder>
 */
class SalesOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'salesorderdate'    => now(),
            'customerid'        => uniqid(),
            'paymentype'        => 'cash',
            'salespersonid'     => 'john doe',
            'salesordergrandtotal'  => 1000,
            'dpp'               => 1000,
            'ppn'               => 10,
            'ppnpercent'        => 20,
            'deliveryto'        => 'Razor',
            'deliveryaddress'   => $this->faker->address(),
            'deliveryphone'     => $this->faker->phoneNumber(),
            'salesordertime'    => now(),
            'status'            => 'completed',
            'processdate'       => now(),
            'processtime'       => now(),
            'processorderno'    => uniqid(),
            'shipping_fee'      => rand(1000, 9999),
            'notes'             => $this->faker->paragraph()
        ];
    }
}
