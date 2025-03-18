<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = User::pluck('id')->toArray();

        foreach ($users as $userId) {
            Address::create([
                'user_id' => $userId,
                'address_line1' => $faker->streetAddress(),
                'address_line2' => $faker->secondaryAddress(),
                'city' => $faker->city(),
                'state' => $faker->state(),
                'postal_code' => $faker->postcode(),
                'country' => $faker->country(),
                'type' => $faker->randomElement(['shipping', 'billing']),
            ]);
        }
    }
}
