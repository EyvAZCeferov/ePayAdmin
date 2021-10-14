<?php

namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Faker::create();

        $customer_names = [
            'az_name' => $faker->company(),
            'ru_name' => $faker->company(),
            'en_name' => $faker->company(),
        ];

        $customer_descriptors = [
            'az_description' => $faker->paragraphs(2, true),
            'ru_description' => $faker->paragraphs(2, true),
            'en_description' => $faker->paragraphs(2, true),
        ];

        $customer_urls = [
            'site' => $faker->domainName(),
            'facebook' => 'https://facebook.com/' . $faker->company(),
            'instagram' => 'https://instagram.com/' . $faker->company(),
            'telephone' => $faker->e164PhoneNumber(),
            'whatsapp' => 'https://wa.me/' . $faker->e164PhoneNumber(),
            'email' => $faker->companyEmail(),
        ];

        $locations_names = [
            'az_name' => $faker->word(),
            'ru_name' => $faker->word(),
            'en_name' => $faker->word(),
        ];

        $location_geolocations = [
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
        ];

        $location_pictures = [
            $faker->imageUrl(640,  480),
            $faker->imageUrl(640,  480),
            $faker->imageUrl(640,  480),
            $faker->imageUrl(640,  480),
        ];

        foreach (range(1, 30) as $index) {
            DB::table('customers')->insert([
                'names' => json_encode($customer_names),
                'descriptors' => json_encode($customer_descriptors),
                'logo' => $faker->imageUrl(640,  480),
                'urls' => json_encode($customer_urls),
                'seo_url' => $faker->slug(),
            ]);

            foreach (range(1, 3) as $i2dex) {
                DB::table('locations')->insert([
                    'names' => json_encode($locations_names),
                    'descriptors' => json_encode($customer_descriptors),
                    'address' => $faker->address(),
                    'geolocations' => json_encode($location_geolocations),
                    'pictures' => json_encode($location_pictures),
                    'customers_id' => Customers::all()->random()->id
                ]);
            }
        };
    }
}
