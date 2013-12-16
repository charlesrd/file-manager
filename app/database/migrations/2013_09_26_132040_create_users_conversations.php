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
		if (Schema::hasTable('users_conversations')) {
			Schema::drop('users_conversations');
		}
		Schema::create('users_conversations', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned(); // USER ID OF RECIPIENT
			$table->integer('conversation_id')->unsigned();
			$table->boolean('read')->default(0);
			$table->boolean('read_admin')->default(0);
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