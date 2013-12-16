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
		// Check for existance of table...
		if (Schema::hasTable('files')) {
			Schema::drop('files');
		}

		// Create the files database table
		Schema::create('files', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('user_id')->nullable();
			$table->integer('batch_id')->unsigned();
			$table->string('filename_original');
			$table->string('filename_random');
			$table->boolean('download_status');
			$table->boolean('shipping_status');
			$table->timestamp('expires_at');
			$table->timestamp('ships_at');
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