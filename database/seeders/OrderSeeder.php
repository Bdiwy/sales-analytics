<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('orders')->insert([
                'product_name' => $faker->name, 
                'quantity' => $faker->numberBetween(1, 100),
                'price' => $faker->randomFloat(2, 10, 500),  
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
