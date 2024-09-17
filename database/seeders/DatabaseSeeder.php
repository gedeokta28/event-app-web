<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory([
            'user_id' => 1,
            'user_name' => 'admin',
            'user_level' => 'admin'
        ])->create();

        \App\Models\User::factory([
            'user_id' => 2,
            'user_name' => 'operator',
            'user_level' => 'operator'
        ])->create();

        // \App\Models\Customer::factory([
        //     'email' => 'customer@example.com'
        // ])->create();

        // $variants = [
        //     'size',
        //     'color',
        // ];

        // foreach ($variants as $variant) {
        //     \App\Models\VariantOption::create([
        //         'name' => $variant
        //     ]);
        // }

        // $variantOptions = \App\Models\VariantOption::get()->pluck('optionid');

        // \App\Models\Brand::factory()
        //     ->count(6)
        //     ->create()
        //     ->each(function ($brand) use ($variantOptions) {
        //         $category = \App\Models\Category::factory()->create();

        //         \App\Models\Stock::factory([
        //             'brandid'       => $brand->brandid,
        //             'categoryid'    => $category->categoryid
        //         ])->count(50)->create()->each(function ($product) use ($variantOptions) {
        //             foreach ($variantOptions as $variantOption) {
        //                 \App\Models\Stock::factory([
        //                     'variant_stockid'   => $product->stockid,
        //                     'variant_optionid'  => $variantOption,
        //                     'brandid'           => $product->brandid,
        //                     'categoryid'        => $product->categoryid
        //                 ])->create();
        //             }
        //         });
        //     });

        // $this->call(CartSeeder::class);

        // $customer = \App\Models\Customer::first();
        // $product = \App\Models\Stock::first();

        // \App\Models\SalesOrder::factory([
        //     'customerid' => $customer->customerid
        // ])->count(10)->create()->each(function ($sales) use ($product) {
        //     \App\Models\SalesOrderDetail::factory([
        //         'stockid'      => $product->stockid,
        //         'salesorderno' => $sales->salesorderno
        //     ])->count(10)->create();
        // });
    }
}
