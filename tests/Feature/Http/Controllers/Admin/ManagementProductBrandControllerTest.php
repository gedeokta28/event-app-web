<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ManagementProductBrandControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_get_list_product_brand()
    {
        $this->actingAsAdmin();

        $this->get(route('brands.index'))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('brands.index'))->assertOk();
    }

    public function test_create_product_brand()
    {
        $this->actingAsAdmin();

        $this->get(route('brands.create'))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('brands.create'))->assertOk();
    }

    public function test_store_product_brand()
    {
        $fakeData = [
            'brandname' => $this->faker->name()
        ];

        $this->actingAsAdmin();

        $this->post(route('brands.store', $fakeData))->assertRedirect(route('brands.index'));

        $this->assertDatabaseCount('brands', 1);

        $fakeData = [
            'brandname' => $this->faker->name()
        ];

        $this->actingAsSuperadmin();

        $this->post(route('brands.store', $fakeData))->assertRedirect(route('brands.index'));

        $this->assertDatabaseCount('brands', 2);
    }

    public function test_edit_product_brand()
    {
        $brand = Brand::factory()->create();

        $this->actingAsAdmin();

        $this->get(route('brands.edit', ['brand' => $brand->brandid]))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('brands.edit', ['brand' => $brand->brandid]))->assertOk();
    }

    public function test_update_product_brand()
    {

        $brand = Brand::factory()->create();

        $fakeData = [
            'brandname' => $this->faker->name()
        ];

        $this->actingAsAdmin();

        $this->put(route('brands.update', ['brand' => $brand->brandid]), $fakeData)
            ->assertSessionHas('success');

        $this->assertEquals($fakeData, [
            'brandname' => $brand->refresh()->brandname
        ]);

        $fakeData = [
            'brandname' => $this->faker->name()
        ];

        $this->actingAsSuperadmin();

        $this->put(route('brands.update', ['brand' => $brand->brandid]), $fakeData)
            ->assertSessionHas('success');

        $this->assertEquals($fakeData, [
            'brandname' => $brand->refresh()->brandname
        ]);
    }

    public function test_delete_product_brand()
    {
        $brands = Brand::factory()->count(2)->create();

        $this->actingAsAdmin();

        $this->delete(route('brands.destroy', ['brand' => $brands[0]->brandid]))->assertOk();

        $this->assertSoftDeleted('brands', [
            'brandid' => $brands[0]->brandid
        ]);

        $this->actingAsSuperadmin();

        $this->delete(route('brands.destroy', ['brand' => $brands[1]->brandid]))->assertOk();

        $this->assertSoftDeleted('brands', [
            'brandid' => $brands[0]->brandid
        ]);
    }
}
