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
		// At this point in time, only user with id=1 (UDRC) should have access to conversations list
		if ($this->user->hasAccess('admin') && $this->user->id == 1) {
			$conversations = Conversation::with('users')->orderBy('created_at', 'desc')->paginate(Config::get('app.pagination_items_per_page'));
			return View::make('admin.message.conversations')->withConversations($conversations);
		} else {
			$conversation = $this->user->conversations->first();
			$messages = null;

			if (!$conversation) {
				return View::make('user.message.messages');
			}
			DB::table('users_conversations')->where('conversation_id', '=', $conversation->id)->update(array('read' => 1));

			$messages = Conversation::find($conversation->id)->messages()->paginate(Config::get('app.pagination_items_per_page'));
			return View::make('user.message.messages')->withMessages($messages);
		}
	}

	public function postMessage() {
		$messageValidationRules = array(
            'message' => 'required'
        );
        $messageValidationMessages = array(
            'message.required' => 'You cannot send a blank message.'
        );

        // Instantiate a validation object
        $messageValidation = Validator::make(Input::all(), $messageValidationRules, $messageValidationMessages);

        if ($messageValidation->fails()) {
        	return Redirect::route('message')->withErrors($messageValidation);
        }

        if (Input::has('conversation_id') && $this->user->id == 1) {
        	$conversation = Conversation::findOrFail(Input::get('conversation_id'));
        } else if ($this->user->hasAccess('users')) {
        	$conversation = $this->user->conversations()->first();
        }

        if (!$conversation) {
        	$conversation = new Conversation;
        	$conversation->save();
        }

		$message = new Message;
		$message->user_id = $this->user->id;
		$message->conversation_id = $conversation->id;
		$message->body = Input::get('message');
		$message->save();

		$conversation->messages()->save($message);
		$conversation->updated_at = date('Y-m-d H:i:s');

		// check if we can find a conversation for this user, if not, attach them
		if (!$conversation->users()->where('user_id', '=', $this->user->id)->first()) {
			$conversation->users()->attach($this->user->id);
		}

		$conversation->save();

		if ($this->user->hasAccess('users')) {
			DB::table('users_conversations')->where('conversation_id', '=', $conversation->id)->update(array('read' => 1, 'read_admin' => 0));
		} else if ($this->user->hasAccess('admin') && $this->user->id == 1) {
			DB::table('users_conversations')->where('conversation_id', '=', $conversation->id)->update(array('read' => 0, 'read_admin' => 1));
		}

		if (Input::has('conversation_id')) {
			return Redirect::route('message_conversation', Input::get('conversation_id'));
		}
		return Redirect::route('message');
	}

	public function getConversation($conversation_id) {
		$conversation = Conversation::with('users')->findOrFail($conversation_id);
		$messages = $conversation->messages()->with('user')->paginate(Config::get('app.pagination_items_per_page'));

		$user_conversation = DB::table('users_conversations')->where('conversation_id', '=', $conversation->id)->update(array('read_admin' => 1));

		return View::make('admin.message.messages')->withConversation($conversation)->withMessages($messages);
	}

}