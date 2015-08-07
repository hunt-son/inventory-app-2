<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

        $word = array('trials', 'rebills', 'dp', 'returned');

		foreach(range(1, 5) as $index)
		{
            $digit = $faker->numberBetween($min = 0, $max = 3);
            $amount = Record::where(function($query) use ($index)
            {
                $query->where('product_id', $index);
            })->sum('amount');
               $product = Product::create([

                   'name' => $faker -> word,
                   'product_id' => $index,
                   "site_link" => $faker -> word,
                   'description' => $faker->paragraph(1),
                   "price_per_bottle" => $faker -> word,
                   "manufacturer" => $faker->firstNameMale,
                   "inhouse" => $amount,
			]);

		}
	}

}

