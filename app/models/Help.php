<?php

// app/models/Help.php

namespace App\Models;
use Eloquent;
use Sentry;
use DB;

class Help extends Eloquent {

	public function user() {
		return $this->belongsTo('User');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedUsedAt() {
		return $this->updated_at->format('g:ia \o\n M j, Y');
	}

	public static function getCurrentRewardsPoints($user_id) {
		$user = Sentry::getUser($user_id);
		if ($user && $user->hasAccess('users')) {
			// return DB::table('users_coupons')->where('user_id', $user_id)->where('file_id', '=', 0);
			return DB::connection('amsrunsheet')->table('labprofile')->where('labID', '=', $this->lab_id)->first();
		}
		return false;
	}

}