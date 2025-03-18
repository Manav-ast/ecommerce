<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Order::create([
                'user_id' => $faker->randomElement($users),
                'order_status' => $faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
                'total_price' => $faker->randomFloat(2, 50, 1000),
                'order_date' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}

