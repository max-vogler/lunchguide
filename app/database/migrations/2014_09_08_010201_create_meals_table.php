<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('meals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('price')->unsigned();
			$table->date('date');
			$table->string('info');
			$table->boolean('featured');
			$table->integer('restaurant_id')->unsigned();
			$table->text('source');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('meals');
	}

}
