<?php

use Illuminate\Database\Migrations\Migration;

class CreateGroups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('groups')) {
			Schema::drop('groups');
		}
		Schema::create('groups', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->text('permissions')->nullable();
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->unique('name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups');
	}

}