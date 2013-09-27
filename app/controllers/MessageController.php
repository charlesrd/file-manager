<?php

class MessageController extends \BaseController {

	public function getIndex()
	{
		Redirect::route('message_inbox');
	}

	public function getInbox()
	{
		return View::make('user.message.inbox');
	}

	public function getOutbox()
	{
		//
	}

}