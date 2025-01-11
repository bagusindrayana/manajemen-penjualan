<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Choco Crunch Cookies',
                'description' => '200g crispy chocolate cookies',
                'stock' => 40,
                'purchase_price' => 25000.00,
                'selling_price' => 40000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organic Almond Milk',
                'description' => '1L unsweetened almond milk',
                'stock' => 30,
                'purchase_price' => 45000.00,
                'selling_price' => 65000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spaghetti Bolognese',
                'description' => 'Instant spaghetti with sauce',
                'stock' => 50,
                'purchase_price' => 20000.00,
                'selling_price' => 30000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium Arabica Coffee',
                'description' => '250g ground coffee beans',
                'stock' => 60,
                'purchase_price' => 50000.00,
                'selling_price' => 75000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green Tea Latte',
                'description' => '300ml ready-to-drink latte',
                'stock' => 80,
                'purchase_price' => 12000.00,
                'selling_price' => 18000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cheese Potato Chips',
                'description' => '150g cheesy potato chips',
                'stock' => 100,
                'purchase_price' => 15000.00,
                'selling_price' => 25000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sparkling Water',
                'description' => '500ml flavored sparkling water',
                'stock' => 70,
                'purchase_price' => 8000.00,
                'selling_price' => 12000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beef Jerky',
                'description' => '100g smoked beef jerky',
                'stock' => 25,
                'purchase_price' => 50000.00,
                'selling_price' => 80000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Energy Bar',
                'description' => 'Protein-packed energy snack',
                'stock' => 90,
                'purchase_price' => 10000.00,
                'selling_price' => 15000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fresh Orange Juice',
                'description' => '1L pure orange juice',
                'stock' => 50,
                'purchase_price' => 20000.00,
                'selling_price' => 35000.00,
                'category' => 'food',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
