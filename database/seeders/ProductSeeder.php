<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Create dummy products
        Product::insert([
            [
                'name' => 'T-Shirt',
                'slug' => Str::slug('T-Shirt'),
                'price' => 19.99,
                'quantity' => 50,
                'image' => 'products/tshirt.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Jeans',
                'slug' => Str::slug('Jeans'),
                'price' => 49.99,
                'quantity' => 30,
                'image' => 'products/jeans.jpg',
                'created_at' => now(),
            ],
            [
                'name' => 'Sneakers',
                'slug' => Str::slug('Sneakers'),
                'price' => 79.99,
                'quantity' => 20,
                'image' => 'products/sneakers.jpg',
                'created_at' => now(),
            ]
        ]);
    }
}
