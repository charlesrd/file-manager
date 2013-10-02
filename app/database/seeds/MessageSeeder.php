<?php

use App\Models\Message;

class MessageSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('messages')->delete();

		$message = new Message;

		$message->user_id = 1;
		$message->conversation_id = 1;
		$message->body = "Hi Casey's Ceramic Arts!  Welcome to the new file manager.";
		$message->save();

		$message1 = new Message;

		$message1->user_id = 2;
		$message1->conversation_id = 1;
		$message1->body = "Thank you UDRC!  This is nice :)";
		$message1->save();

		$message2 = new Message;

		$message2->user_id = 1;
		$message2->conversation_id = 1;
		$message2->body = "Thank you!  We put a lot of work into it.";
		$message2->save();
	}

}