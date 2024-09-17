<?php

namespace Tests\Feature\Helpers;

use App\Helpers\StockHelper;
use Database\Seeders\StockSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockHelperTest extends TestCase
{

    use RefreshDatabase;

    public function test_calculate_grocery_price()
    {
        $this->seed(StockSeeder::class);

        $stock = \App\Models\Stock::first();

        for ($i = 0; $i < 105; $i += 5) {
            if ($i == 0) {
                $this->assertEquals(10_000, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 10) {
                $this->assertEquals(5_750, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 100) {
                $this->assertEquals(5_500, StockHelper::groceryPrice($stock, $i));
            } else {
                $this->assertEquals(5_250, StockHelper::groceryPrice($stock, $i));
            }
        }
    }

    public function test_calculate_grocery_discount_percent()
    {
        $this->seed(StockSeeder::class);

        $stock = \App\Models\Stock::first();

        for ($i = 0; $i < 105; $i += 5) {
            if ($i == 0) {
                $this->assertEquals(0, StockHelper::groceryDiscountPercentage($stock, $i));
            } else if ($i < 10) {
                $this->assertEquals(42.5, StockHelper::groceryDiscountPercentage($stock, $i));
            } else if ($i < 100) {
                $this->assertEquals(45, StockHelper::groceryDiscountPercentage($stock, $i));
            } else {
                $this->assertEquals(47.5, StockHelper::groceryDiscountPercentage($stock, $i));
            }
        }
    }

    public function test_calculate_grocery_discount_amount()
    {
        $this->seed(StockSeeder::class);

        $stock = \App\Models\Stock::first();

        for ($i = 0; $i < 105; $i += 5) {
            if ($i == 0) {
                $this->assertEquals(0, StockHelper::groceryDiscountAmount($stock, $i));
            } else if ($i < 10) {
                $this->assertEquals((10_000 - 5_750), StockHelper::groceryDiscountAmount($stock, $i));
            } else if ($i < 100) {
                $this->assertEquals((10_000 - 5_500), StockHelper::groceryDiscountAmount($stock, $i));
            } else {
                $this->assertEquals((10_000 - 5_250), StockHelper::groceryDiscountAmount($stock, $i));
            }
        }
    }

    public function test_calculate_grocery_price_abnormal_condition_1()
    {
        $this->seed(StockSeeder::class);

        $stock = \App\Models\Stock::first();

        // make disclist2 is null
        $stock->update(['disclist2' => null]);

        for ($i = 0; $i < 105; $i += 5) {
            if ($i == 0) {
                $this->assertEquals(10_000, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 10) {
                $this->assertEquals(5_750, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 100) {
                $this->assertEquals(10_000, StockHelper::groceryPrice($stock, $i));
            } else {
                $this->assertEquals(5_250, StockHelper::groceryPrice($stock, $i));
            }
        }
    }

    public function test_calculate_grocery_price_abnormal_condition_2()
    {
        $this->seed(StockSeeder::class);

        $stock = \App\Models\Stock::first();

        // make disclist2 & qty2 is null
        $stock->update(['disclist2' => null]);

        for ($i = 0; $i < 105; $i += 5) {
            if ($i == 0) {
                $this->assertEquals(10_000, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 10) {
                $this->assertEquals(5_750, StockHelper::groceryPrice($stock, $i));
            } else if ($i < 100) {
                $this->assertEquals(10_000, StockHelper::groceryPrice($stock, $i));
            } else {
                $this->assertEquals(5_250, StockHelper::groceryPrice($stock, $i));
            }
        }
    }
}
