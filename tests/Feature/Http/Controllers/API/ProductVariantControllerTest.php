<?php

namespace Tests\Feature\Http\Controllers\API;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductVariantControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $variants = [
            'size',
            'color',
        ];

        foreach ($variants as $variant) {
            \App\Models\VariantOption::create([
                'name' => $variant
            ]);
        }

        $variantOptions = \App\Models\VariantOption::get()->pluck('optionid');

        \App\Models\Brand::factory()
            ->count(2)
            ->create()
            ->each(function ($brand) use ($variantOptions) {
                $category = \App\Models\Category::factory()->create();

                \App\Models\Stock::factory([
                    'brandid'       => $brand->brandid,
                    'categoryid'    => $category->categoryid
                ])->count(2)->create()->each(function ($product) use ($variantOptions) {
                    foreach ($variantOptions as $variantOption) {
                        \App\Models\Stock::factory([
                            'variant_stockid'   => $product->stockid,
                            'variant_optionid'  => $variantOption,
                            'brandid'           => $product->brandid,
                            'categoryid'        => $product->categoryid
                        ])->create();
                    }
                });
            });
    }

    public function test_get_product_variant()
    {
        $product = \App\Models\Stock::first();

        $this->getJson(route('api.product_variants.index', ['product' => $product->stockid]))
            ->assertOk()
            ->assertJsonCount($product->variants()->count(), 'data');
    }

    public function test_get_product_variant_detail()
    {
        $product = \App\Models\Stock::first();

        $productVariant = $product->variants[0];

        $this->getJson(route('api.product_variants.show', [
            'product'   => $product->stockid,
            'variant'   => $productVariant->stockid
        ]))
            ->assertOk()
            ->assertSee($productVariant->name);
    }
}
