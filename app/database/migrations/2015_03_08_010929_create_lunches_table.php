<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLunchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lunches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->dateTime('deadline');
			$table->timestamps();
		});

		Schema::create('lunch_friends', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('lunch_id');
			$table->integer('friend_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lunches');
		Schema::drop('lunch_friends');
	}

}
