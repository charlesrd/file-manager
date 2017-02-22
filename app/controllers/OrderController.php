<?php

use App\Models\Order;
use App\Models\Conversation;
use App\Models\Users;

class OrderController extends \BaseController {

	public function __construct() {
		parent::__construct();

		$this->beforeFilter('auth');
	}

	public function getIndex() {
		if ($this->user->hasAccess('users')) {
			return View::make('user.order.scan_flags');
		}
	}

	public function postOrder() {
		$order = new Order;
		$order->user_id = $this->user->id;
		$order->conversation_id = $conversation->id;
		$order->body = Input::get('order');
		$order->save();

		$conversation->orders()->save($order);
		$conversation->updated_at = date('Y-m-d H:i:s');

		$conversation->save();

		return Redirect::route('order');
	}

}