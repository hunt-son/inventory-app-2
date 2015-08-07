<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name');
            $table->integer('product_id');
            $table->string("logo")->nullable();
            $table->string("site_link");
            $table->string("description");
            $table->integer("price_per_bottle");
            $table->string('manufacturer')->nullable();
            $table->string('action');
            $table->integer('inhouse');
            $table->integer('daysleft');
            $table->integer('weekly_average');
            $table->integer('change');
            $table->integer('total_sold');
			$table->timestamps();
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
