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
			$table->bigInteger('id')->unsigned();
			$table->bigInteger('file_id')->unsigned();
			$table->integer('user_id')->unsigned();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';

			// Set the table keys for relationships
			$table->primary(array('id', 'file_id'));
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