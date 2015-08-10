<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('lunch_restaurants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lunch_id');
			$table->integer('restaurant_id');
		});

		Schema::create('lunch_restaurant_ranks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lunch_restaurant_id');
			$table->integer('user_id');
			$table->integer('rank');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('restaurants');
		Schema::drop('lunch_restaurants');
		Schema::drop('lunch_restaurant_ranks');
	}

}
