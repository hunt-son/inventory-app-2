<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class RecordsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();


		foreach(range(1, 50) as $index)
		{
            $number = rand(1,5);
            $product = Product::find($number);
			Record::create([
                "name" => $product->name,
                "action" => "trials",
                "status" => "comes_in",
                "authorization" => $faker->firstNameFemale,
                "amount" => 5 + ($index * 5),
                "product_id" => $number

			]);
		}
	}

}
