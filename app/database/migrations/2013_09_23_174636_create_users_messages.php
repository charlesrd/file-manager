<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_messages', function($table)
		{
			$table->integer('from_user_id')->unsigned();
			$table->integer('to_user_id')->unsigned();
			$table->integer('message_id')->unsigned();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->primary(array('to_user_id', 'from_user_id', 'message_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_messages');
	}

}