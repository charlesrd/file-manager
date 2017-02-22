<?php

// app/models/Conversation.php

namespace App\Models;
use Eloquent;
use Sentry;
use DB;

class Conversation extends Eloquent {

	public function users() {
		return $this->belongsToMany('User', 'users_conversations')->withPivot('read', 'read_admin');
	}

	public function messages() {
		return $this->hasMany('App\Models\Message');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedUpdatedAt() {
		return $this->updated_at->format('g:ia \o\n M j, Y');
	}

	public static function getUnreadConversations($user_id) {
		$user = Sentry::getUser($user_id);
		if ($user && $user->hasAccess('admin') && $user->id == 1) {
			return DB::table('users_conversations')->where('read_admin', 0)->where('user_id', '!=', $user->id);
		} else if ($user && $user->hasAccess('users')) {
			return DB::table('users_conversations')->where('user_id', $user_id)->where('read', 0);
		}
		return false;
	}

	public static function getUnusedScanFlagCoupons($user_id) {
		$user = Sentry::getUser($user_id);
		if ($user && $user->hasAccess('users')) {
			return DB::table('users_coupons')->where('user_id', $user_id)->where('file_id', '=', 0);
		}
		return false;
	}

}