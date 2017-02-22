<?php

use App\Models\Rewards;
use App\Models\Conversation;
use App\Models\Users;

class RewardsController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$this->beforeFilter('auth');
	}

	public function getIndex() {
		if ($this->user->hasAccess('users')) {
			// return Redirect::route('rewards_test');
			return View::make('user.rewards.home');
		}
	}

	public function getTest() {
		if ($this->user->hasAccess('users')) {
			return View::make('user.rewards.test');
		}
	}

	public function postRewards() {
		$rewards = new Rewards;
		$rewards->user_id = $this->user->id;
		$rewards->conversation_id = $conversation->id;
		$rewards->body = Input::get('rewards');
		$rewards->save();

		$conversation->orders()->save($rewards);
		$conversation->updated_at = date('Y-m-d H:i:s');

		$conversation->save();

		return Redirect::route('rewards');
	}

}