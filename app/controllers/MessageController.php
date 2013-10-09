<?php

use App\Models\Message;
use App\Models\Conversation;
use App\Models\Users;

class MessageController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$this->beforeFilter('auth');
	}

	public function getIndex() {
		if ($this->user->id == 1) {
			//$conversations = 
		} else {
			$conversation = $this->user->conversations->first();

			if ($conversation) {
				$messages = Conversation::find($conversation->id)->messages()->paginate(15);
			} else {
				$messages = null;
			}

			//$messages = Message::where('from_user_id', '=', $this->user->id)->orWhere('to_user_id', '=', $this->user->id)->orderBy('id', 'DESC')->paginate(15);
		
			return View::make('user.message.messages')->with('messages', $messages);
		}
	}

	public function postIndex() {
		$message = new Message;
		$message->user_id = $this->user->id;
		$message->conversation_id = 1;
		$message->body = Input::get('message');
		if ($message->save()) {
			return Redirect::route('message');
		}
	}

}