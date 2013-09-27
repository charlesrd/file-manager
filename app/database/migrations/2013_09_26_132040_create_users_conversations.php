<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersConversations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_conversations', function($table)
		{
			$table->bigIncrements('id');
			$table->integer('user_id');
			$table->integer('conversation_id');
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
		Schema::drop('users_conversations');
	}

}