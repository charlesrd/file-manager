<?php

// app/models/File.php

namespace App\Models;
use DB;
use Eloquent;
use Config;

class File extends Eloquent {

	// public function user() {
	// 	return $this->hasOne('User');
	// }

	public function user() {
		return $this->belongsTo('User');
		//return DB::table('users')->where('id', '=', $this->user_id)->first();
	}

	public function batch() {
		return $this->belongsTo('Batch');
		//return DB::table('batches')->where('id', '=', $$this->batch_id)->first();
	}

	// public function user() {
	// 	return \DB::table('users')->where('id', '=', $this->user_id)->first();
	// }

	// public function batch() {
	// 	return \DB::table('batches')->where('id', '=', $this->batch_id)
	// 								->first();
	// }

	public function getDates() {
		return array('created_at', 'updated_at', 'deleted_at', 'expiration');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedExpiration() {
		return $this->expiration->format('M j, Y');
	}

	public static function findAllWithSearchPhrase($searchPhrase, $user) {
		if ($user->hasAccess('admin') || $user->hasAccess('superuser')) {
			return File::where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
				->orWhere('tracking', 'LIKE', '%' . $searchPhrase . '%')
				->paginate(Config::get('app.pagination_items_per_page'));
		} else {
			return File::where('user_id', '=', $user->id)->
				where('filename_original', 'LIKE', '%' . $searchPhrase . '%')
				->orWhere('tracking', 'LIKE', '%' . $searchPhrase . '%')
				->paginate(Config::get('app.pagination_items_per_page'));
		}
	}

}