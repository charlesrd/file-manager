<?php

use App\Models\Conversation;

class ConversationSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('conversations')->delete();

		$conversation = new Conversation;

		$conversation->id = 1;
		$conversation->save();
	}

}