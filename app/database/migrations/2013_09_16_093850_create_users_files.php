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
		if (Schema::hasTable('users_files')) {
			Schema::drop('users_files');
		}
		Schema::create('users_files', function($table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('file_id')->unsigned();
			$table->integer('batch_id')->unsigned();

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