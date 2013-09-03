<?php

use Illuminate\Database\Migrations\Migration;

class CreateFiles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create the files database table
		Schema::create('files', function($table) {
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->string('filename_original');
			$table->string('filename_random');
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
		// Rollback table creation
		Schema::drop('files');
	}

}