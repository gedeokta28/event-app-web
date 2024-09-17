<?php

namespace Tests\Feature\Http\Controllers\API;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Stock;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_stock_info()
    {

        $products = \App\Models\Stock::factory()->count(10)->create();

        $this->getJson(route('api.stocks.index'))
            ->assertOk()
            ->assertSee($products[0]['stockid'])
            ->assertJsonCount(10, 'data');
    }

    public function test_get_stock_detail()
    {
        $products = \App\Models\Stock::factory()->count(10)->create();
        $this->getJson(route('api.stocks.show', ['product' => $products[0]->stockid]))
            ->assertOk()
            ->assertSee($products[0]->stockid);
    }

    public function test_filter_stock_with_single_categoryid()
    {

        $this->seed(StockSeeder::class);

        $priceStart = 0;
        $priceEnd = 10000;

        $category = Category::first();

        $this->getJson(route('api.products.search.stockitem', [
            'pricestart' => $priceStart,
            'priceend' => $priceEnd,
            'categoryid' => $category->categoryid,
            'limit' => 10 // make sure to get all of them
        ]))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertSee($category->categoryid);
    }

    public function test_filter_stock_with_single_brandid()
    {

        $this->seed(StockSeeder::class);

        $priceStart = 0;
        $priceEnd = 10000;

        $brand = Brand::first();

        $this->getJson(route('api.products.search.stockitem', [
            'pricestart' => $priceStart,
            'priceend' => $priceEnd,
            'brandid' => $brand->brandid,
            'limit' => 10 // make sure to get all of them
        ]))
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertSee($brand->brandid);
    }

    public function test_filter_stock_with_multi_categoryid()
    {

        $this->seed(StockSeeder::class);

        $priceStart = 0;
        $priceEnd = 10000;

        $categories = Category::limit(3)->get()->pluck('categoryid');

        $this->getJson(route('api.products.search.stockitem', [
            'pricestart' => $priceStart,
            'priceend' => $priceEnd,
            'categoryid' => $categories->join(","),
            'limit' => 10 // make sure to get all of them
        ]))
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertSee($categories->toArray());
    }

    public function test_filter_stock_with_multi_brandid()
    {

        $this->seed(StockSeeder::class);

        $priceStart = 0;
        $priceEnd = 10000;

        $brands = Brand::limit(3)->get()->pluck('brandid');

        $this->getJson(route('api.products.search.stockitem', [
            'pricestart' => $priceStart,
            'priceend' => $priceEnd,
            'brandid' => $brands->join(","),
            'limit' => 10 // make sure to get all of them
        ]))
            ->assertOk()
            ->assertJsonCount(6, 'data')
            ->assertSee($brands->toArray());
    }

    public function test_get_only_stockname()
    {
        $this->seed(StockSeeder::class);

        $this->getJson(route('api.products.search.stockname'))
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertSee('stockname');
    }
}
