<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use Faker\Factory as Faker;

class OrderItemSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $orders = Order::pluck('id')->toArray();
        $products = Product::pluck('id')->toArray();        

        for ($i = 0; $i < 30; $i++) {
            OrderItem::create([
                'order_id' => $faker->randomElement($orders),
                'product_id' => $faker->randomElement($products),
                'quantity' => $faker->numberBetween(1, 5),
                'price' => $faker->randomFloat(2, 10, 500),
            ]);
        }
    }
}

