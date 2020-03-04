<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            ["id" => 1, "name" => "Chips With Bacon", "price" => 0.99, "amount_per_palete" => 10],
            ["id" => 2, "name" => "Choko cookie 100g", "price" => 1.55, "amount_per_palete" => 30],
            ["id" => 3, "name" => "T-Shirt 'Hello'", "price" => 5.87, "amount_per_palete" => 100],
            ["id" => 4, "name" => "Chips With Taco", "price" => 0.99, "amount_per_palete" => 6],
        ];

        App\Product::insert($products);

        $enterprise_products = [
            ["enterprise_id" => 1, "product_id" => 2, "sale_price" => 1.47, "amount" => 199],
            ["enterprise_id" => 2, "product_id" => 2, "sale_price" => 2.52, "amount" => 523],
            ["enterprise_id" => 2, "product_id" => 4, "sale_price" => 1.52,"amount" => 62],
            ["enterprise_id" => 1, "product_id" => 1, "sale_price" => 3.33,"amount" => 613],
        ];
        DB::table("enterprise_product")->insert($enterprise_products);
    }
}
