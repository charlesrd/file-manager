<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_files', function($table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('file_id')->unsigned();
			$table->integer('batch_id')->unsigned();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';

			// Set the table keys for relationships
			$table->primary(array('user_id', 'file_id', 'batch_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_files');
	}

}