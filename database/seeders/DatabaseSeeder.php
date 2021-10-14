<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\TermOfUsesSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            TermOfUsesSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class
        ]);
    }
}
