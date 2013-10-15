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
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->integer('batch_id');
			$table->string('filename_original');
			$table->string('filename_random');
			$table->boolean('download_status');
			$table->boolean('shipping_status');
			$table->string('tracking')->nullable();
			$table->timestamp('expiration');
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
		});

		if (Schema::hasColumn('files', 'expiration')) {
			DB::unprepared('CREATE TRIGGER set_file_expiration 
						   BEFORE INSERT ON `files` 
						   FOR EACH ROW SET NEW.expiration = TIMESTAMPADD(WEEK, 1, NOW())');
		}
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