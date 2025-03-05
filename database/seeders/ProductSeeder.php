<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => 'Kaos Oblong',
            'category_id' => 1,
            'product_price' => 50000,
            'product_stock' => 100,
            'product_description' => 'Kaos oblong berwarna putih',
        ]);

        Product::create([
            'product_name' => 'Celana Jeans',
            'category_id' => 2,
            'product_price' => 150000,
            'product_stock' => 50,
            'product_description' => 'Celana jeans berwarna biru',
        ]);

        Product::create([
            'product_name' => 'Topi',
            'category_id' => 3,
            'product_price' => 30000,
            'product_stock' => 200,
            'product_description' => 'Topi berwarna hitam',
        ]);  
    }
}
