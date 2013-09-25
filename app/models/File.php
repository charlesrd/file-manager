<?php

// app/models/File.php

namespace App\Models;

class File extends \Eloquent {

	// public function user() {
	// 	return $this->hasOne('User');
	// }

	public function user() {
		return \DB::table('users')->where('id', '=', $this->user_id)->first();
	}

	public function batch() {
		return \DB::table('batches')->where('id', '=', $this->batch_id)
									->first();
	}

}