<?php

namespace Database\Factories;

use App\Helpers\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customername'      => $this->faker->name(),
            'address'           => $this->faker->streetAddress(),
            'city'              => $this->faker->city(),
            'postcode'          => $this->faker->postcode(),
            'phone'             => $this->faker->phoneNumber(),
            'email'             => $this->faker->safeEmail(),
            'registerdate'      => now(),
            'contactperson'     => $this->faker->name(),
            'password'          => Hash::make('password'),
            'companyname'       => $this->faker->company(),
            'province'          => $this->faker->city(),
            'fcm_token'         => $this->faker->uuid(),
            'internalcode'      => $this->faker->uuid(),
            'account_type'      => $this->faker->randomElement([AccountType::ACCOUNT_PERSONAL, AccountType::ACCOUNT_COMPANY]),
            'npwp'              => $this->faker->uuid(),
            'noktp'             => substr($this->faker->uuid(), 0, 16),
        ];
    }
}
