<?php

use Illuminate\Database\Migrations\Migration;

class CreateBatches extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('batches', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->text('guest_lab_name')->nullable();
			$table->text('guest_lab_email')->nullable();
			$table->text('guest_lab_phone')->nullable();
			$table->text('message')->nullable();
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('batches');
	}

}