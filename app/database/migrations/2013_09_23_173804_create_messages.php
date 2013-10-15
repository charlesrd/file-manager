<?php

use Illuminate\Database\Migrations\Migration;

class CreateMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (Schema::hasTable('messages')) {
			Schema::drop('files');
		}
		Schema::create('messages', function($table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id'); // USER_ID OF THE SENDER
			$table->integer('conversation_id');
			$table->text('body');
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
		Schema::drop('messages');
	}

}