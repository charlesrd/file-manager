<?php

// app/models/Order.php

namespace App\Models;
use Eloquent;
use Sentry;
use DB;

class Order extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedUsedAt() {
		return $this->updated_at->format('g:ia \o\n M j, Y');
	}

	public static function getUnusedScanFlagCoupons($user_id) {
		$user = Sentry::getUser($user_id);
		if ($user && $user->hasAccess('users')) {
			return DB::table('users_coupons')->where('user_id', $user_id)->where('file_id', '=', 0);
		}
		return false;
	}

}