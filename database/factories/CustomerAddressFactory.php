<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerAddress>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fullname'          => $this->faker->address(),
            'phone'             => $this->faker->phoneNumber(),
            'province'          => $this->faker->streetAddress(),
            'city'              => $this->faker->streetAddress(),
            'street_address'    => $this->faker->streetAddress(),
        ];
    }
}
