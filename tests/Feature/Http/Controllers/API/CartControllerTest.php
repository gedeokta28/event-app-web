<?php

namespace Tests\Feature\Http\Controllers\API;

use Database\Seeders\CartSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cart_list()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $this->getJson(route('api.carts.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertSee([
                'qty' => 1
            ]);
    }

    public function test_add_same_product_to_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $product = \App\Models\Stock::first();

        $this->postJson(route('api.carts.store'), [
            'stockid'   => $product->stockid,
            'qty'       => 2
        ])
            ->assertOk()
            ->assertSee([
                'qty' => 3
            ]);

        $this->assertDatabaseHas('carts', [
            'customerid' => Auth::id(),
            'qty' => 3,
            'stockid'   => $product->stockid
        ]);
    }

    public function test_add_different_product_to_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $product = \App\Models\Stock::all()[2];

        $this->postJson(route('api.carts.store'), [
            'stockid'   => $product->stockid,
            'qty'       => 2
        ])
            ->assertCreated()
            ->assertSee([
                'qty' => 2
            ]);

        $this->assertDatabaseHas('carts', [
            'customerid' => Auth::id(),
            'qty' => 2,
            'stockid'   => $product->stockid
        ]);

        $this->assertDatabaseCount('carts', 2);
    }

    public function test_add_product_variant_to_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $product = \App\Models\Stock::first();
        $variant = $product->variants[0];

        $this->postJson(route('api.carts.store'), [
            'stockid'               => $variant->stockid,
            'qty'                   => 2,
        ])
            ->assertCreated()
            ->assertSee([
                'qty' => 2
            ]);

        $this->assertDatabaseHas('carts', [
            'customerid' => Auth::id(),
            'qty' => 2,
            'stockid'   => $variant->stockid
        ]);

        $this->assertDatabaseCount('carts', 2);
    }

    public function test_modify_quantity_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $cart = $customer->carts()->first();

        $this->putJson(route('api.carts.update', ['cart' => $cart->id]), [
            'qty'       => 12
        ])
            ->assertOk()
            ->assertSee([
                'qty' => 12
            ]);

        $this->assertDatabaseHas('carts', [
            'customerid' => Auth::id(),
            'qty' => 12,
            'id'    => $cart->id
        ]);
    }

    public function test_delete_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $cart = $customer->carts()->first();

        $this->delete(route('api.carts.destroy', ['cart' => $cart->id]))
            ->assertOk();

        $this->assertSoftDeleted('carts', [
            'customerid' => Auth::id(),
            'id'    => $cart->id
        ]);
    }

    public function test_truncate_cart()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $cart = $customer->carts()->first();

        $this->delete(route('api.carts.truncate'))
            ->assertOk();

        $this->assertSoftDeleted('carts', [
            'customerid' => Auth::id(),
            'id'    => $cart->id
        ]);
    }

    public function test_error_invalid_stockid()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $this->postJson(route('api.carts.store'), [
            'stockid'   => 'testing',
            'qty'       => 2
        ])
            ->assertStatus(422)
            ->assertSee('stockid');
    }

    public function test_error_invalid_product_variant()
    {

        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $product = \App\Models\Stock::first();

        $this->postJson(route('api.carts.store'), [
            'stockid'               => 123123,
            'qty'                   => 2,
        ])
            ->assertStatus(422)
            ->assertSee('stockid');
    }

    public function test_error_invalid_delete_cart_id()
    {
        $this->seed(CartSeeder::class);

        $customer = \App\Models\Customer::first();

        $this->loginWithJWT($customer);

        $this->delete(route('api.carts.destroy', ['cart' => 123123]))
            ->assertNotFound();
    }
}
