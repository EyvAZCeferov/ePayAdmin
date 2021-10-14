<?php

namespace Database\Seeders;

use App\Models\Devices;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Faker::create();
        foreach (range(1, 2000) as $index) {
            DB::table('users')->insert([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'phone' => $faker->unique()->phoneNumber(),
                'picture' => $faker->imageUrl(150, 150, 'profile', true),
                'remember_token' => Str::random(10),
            ]);

            DB::table('devices')->insert([
                'user_id' => $index,
                'device' => 'web',
                'browser' => $faker->chrome(),
                'ip_address' => $faker->ipv4()
            ]);

            DB::table('cards')->insert([
                'card_number' => $faker->creditCardNumber(),
                'card_type' => $faker->creditCardType(),
                'category' => 'pin',
                'expiry_date' => $faker->creditCardExpirationDateString(),
                'user_id' => $index,
            ]);
        }
    }
}
