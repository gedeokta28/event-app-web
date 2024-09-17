<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManagementProductCategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_get_list_product_category()
    {
        $this->actingAsAdmin();

        $this->get(route('categories.index'))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('categories.index'))->assertOk();
    }

    public function test_create_product_category()
    {
        $this->actingAsAdmin();

        $this->get(route('categories.create'))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('categories.create'))->assertOk();
    }

    public function test_store_product_category()
    {
        $fakeData = [
            'categoryname' => $this->faker->name()
        ];

        $this->actingAsAdmin();

        $this->post(route('categories.store', $fakeData))->assertRedirect(route('categories.index'));

        $this->assertDatabaseCount('categories', 1);

        $fakeData = [
            'categoryname' => $this->faker->name()
        ];

        $this->actingAsSuperadmin();

        $this->post(route('categories.store', $fakeData))->assertRedirect(route('categories.index'));

        $this->assertDatabaseCount('categories', 2);
    }

    public function test_edit_product_category()
    {
        $category = Category::factory()->create();

        $this->actingAsAdmin();

        $this->get(route('categories.edit', ['category' => $category->categoryid]))->assertOk();

        $this->actingAsSuperadmin();

        $this->get(route('categories.edit', ['category' => $category->categoryid]))->assertOk();
    }

    public function test_update_product_category()
    {

        $category = Category::factory()->create();

        $fakeData = [
            'categoryname' => $this->faker->name()
        ];

        $this->actingAsAdmin();

        $this->put(route('categories.update', ['category' => $category->categoryid]), $fakeData)
            ->assertSessionHas('success');

        $this->assertEquals($fakeData, [
            'categoryname' => $category->refresh()->categoryname
        ]);

        $fakeData = [
            'categoryname' => $this->faker->name()
        ];

        $this->actingAsSuperadmin();

        $this->put(route('categories.update', ['category' => $category->categoryid]), $fakeData)
            ->assertSessionHas('success');

        $this->assertEquals($fakeData, [
            'categoryname' => $category->refresh()->categoryname
        ]);
    }

    public function test_delete_product_category()
    {
        $categories = Category::factory()->count(2)->create();

        $this->actingAsAdmin();

        $this->delete(route('categories.destroy', ['category' => $categories[0]->categoryid]))->assertOk();

        $this->assertSoftDeleted('categories', [
            'categoryid' => $categories[0]->categoryid
        ]);

        $this->actingAsSuperadmin();

        $this->delete(route('categories.destroy', ['category' => $categories[1]->categoryid]))->assertOk();

        $this->assertSoftDeleted('categories', [
            'categoryid' => $categories[0]->categoryid
        ]);
    }
}
