<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\User;
use App\Models\Roles;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" =>  "Manav",
            "email" =>  "manav@gmail.com",
            "password"  =>  Hash::make("Test@1234"),
            "status"    =>  "active",
            "phone_no" => "1234567890",
        ]);

        Roles::create([
            "role_name" =>  "Admin",
            "description" =>  "Admin Role",
        ]);

        Admin::create([
            "name" =>  "Admin",
            "email" =>  "admin@gmail.com",
            "password"  =>  Hash::make("Admin@1234"),
            "role_id" => 1,
        ]);

        // $this->call([
        //     OrderSeeder::class,
        //     OrderItemSeeder::class,
        //     PaymentSeeder::class,
        //     AddressSeeder::class,
        // ]);
    }
}
