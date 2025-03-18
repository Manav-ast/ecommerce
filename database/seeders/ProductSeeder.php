<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $faker->word,
                'slug' => $faker->unique()->slug,
                'price' => $faker->randomFloat(2, 10, 500),
                'stock_quantity' => $faker->numberBetween(1, 100),
                'image' => 'default.jpg',
            ]);
        }
    }
}
