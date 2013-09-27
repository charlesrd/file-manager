<?php

// app/models/File.php

namespace App\Models;

class File extends \Eloquent {

	// public function user() {
	// 	return $this->hasOne('User');
	// }

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function batch() {
		return $this->belongsTo('App\Models\Batch');
	}

	// public function user() {
	// 	return \DB::table('users')->where('id', '=', $this->user_id)->first();
	// }

	// public function batch() {
	// 	return \DB::table('batches')->where('id', '=', $this->batch_id)
	// 								->first();
	// }

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia - M j, Y');
	}

}