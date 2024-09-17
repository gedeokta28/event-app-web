<?php

namespace Tests\Feature\Http\Controllers\API;

use Database\Seeders\CartSeeder;
use Database\Seeders\SalesOrderSeeder;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_guard()
    {
        $this->getJson(route('api.orders.index'))->assertUnauthorized();
    }

    public function test_create_order()
    {
        $customer = \App\Models\Customer::factory()->create();
        $this->seed([
            StockSeeder::class,
            CartSeeder::class,
        ]);

        $customerAddr = \App\Models\CustomerAddress::factory([
            'customerid' => $customer->customerid
        ])->create();

        $this->loginWithJWT($customer);

        $customer->carts()->update(['qty' => 9]);

        // checkout cart
        $this->postJson(route('api.orders.store'), [
            'cart_ids'          => $customer->carts->pluck('id')->toArray(),
            'payment_method'    => 'transfer bank',
            'note'              => 'testing',
            'address_id'        => $customerAddr->id
        ])->assertCreated();

        $this->assertDatabaseCount('sales_orders', 1);

        $customer->refresh();

        $customer->carts->each(function ($cart) {
            $this->assertNotNull($cart->checkout_at);
        });
    }

    public function test_get_list_order()
    {
        $this->seed(SalesOrderSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->actingAs($customer, 'api');

        $this->getJson(route('api.orders.index'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'salesorderno',
                        'products',
                    ]
                ]
            ]);
    }

    public function test_get_detail_order()
    {
        $this->seed(SalesOrderSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->actingAs($customer, 'api');

        $this->getJson(route('api.orders.show', [
            'order' => $customer->orders[0]->salesorderno
        ]))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'salesorderno',
                    'products',
                ]
            ]);
    }
}
