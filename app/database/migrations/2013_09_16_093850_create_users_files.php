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
			$table->integer('user_id');
			$table->integer('file_id');
			$table->integer('batch_id');

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
		Schema::drop('users_files');
	}

}