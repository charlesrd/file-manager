<?php

// app/models/Batch.php

namespace App\Models;

class Batch extends \Eloquent {

	protected $table = "batches";

	public function files() {
		return $this->hasMany('App\Models\File');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

}