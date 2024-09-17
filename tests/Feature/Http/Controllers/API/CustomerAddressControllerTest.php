<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerAddressControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_stored_address()
    {
        $customer = \App\Models\Customer::factory()->create();

        $addresses = \App\Models\CustomerAddress::factory([
            'customerid' => $customer->customerid
        ])->count(5)->create();

        $this->loginWithJWT($customer);

        $this->getJson(route('api.address.index'))
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_store_new_address()
    {
        $customer = \App\Models\Customer::factory()->create();

        $this->loginWithJWT($customer);

        $newAddress = [
            'fullname'          => $this->faker->name(),
            'phone'             => $this->faker->phoneNumber(),
            'province'          => 'Bali',
            'city'              => 'Denpasar',
            'street_address'    => 'Jln. Samudra',
            'address_detail'    => 'testing'
        ];

        $this->postJson(route('api.address.store'), $newAddress)
            ->assertCreated()
            ->assertSee($newAddress);

        $this->assertDatabaseCount('customer_addresses', 1);

        $this->assertDatabaseHas('customer_addresses', $newAddress);
    }

    public function test_update_address()
    {
        $customer = \App\Models\Customer::factory()->create();

        $address = \App\Models\CustomerAddress::factory([
            'customerid'    => $customer->customerid
        ])->create();

        $this->loginWithJWT($customer);

        $newAddress = [
            'fullname'          => $this->faker->name(),
            'phone'             => $this->faker->phoneNumber(),
            'province'          => 'Bali',
            'city'              => 'Denpasar',
            'street_address'    => 'Jln. Samudra',
            'address_detail'    => 'testing'
        ];

        $this->putJson(route('api.address.update', ['address' => $address->id]), $newAddress)
            ->assertOk()
            ->assertSee($newAddress);

        $this->assertDatabaseCount('customer_addresses', 1);

        $this->assertDatabaseHas('customer_addresses', $newAddress);
    }

    public function test_delete_address()
    {
        $customer = \App\Models\Customer::factory()->create();

        $address = \App\Models\CustomerAddress::factory([
            'customerid'    => $customer->customerid
        ])->create();

        $this->loginWithJWT($customer);

        $this->delete(route('api.address.destroy', ['address' => $address->id]))
            ->assertOk();

        $this->assertDatabaseCount('customer_addresses', 1);

        $this->assertSoftDeleted('customer_addresses', [
            'id' => $address->id
        ]);
    }

    public function test_show_address()
    {
        $customer = \App\Models\Customer::factory()->create();

        $address = \App\Models\CustomerAddress::factory([
            'customerid'    => $customer->customerid
        ])->create();

        $this->loginWithJWT($customer);

        $this->getJson(route('api.address.show', ['address' => $address->id]))
            ->assertOk()
            ->assertSee([
                'id' => $address->id
            ]);
    }
}
