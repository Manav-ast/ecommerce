<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Order;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $orders = Order::pluck('id')->toArray();

        foreach ($orders as $orderId) {
            Payment::create([
                'order_id' => $orderId,
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'bank_transfer']),
                'payment_status' => $faker->randomElement(['pending', 'completed', 'failed']),
                'amount' => $faker->randomFloat(2, 50, 1000),
                'payment_date' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
