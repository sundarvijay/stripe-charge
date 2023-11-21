<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('de_DE');
        Product::create([
            'name' => Str::random(10),
            'price' => random_int(1, 1000),
            'description' => $faker->text($maxNbChars = 100),
        ]);
    }
}
