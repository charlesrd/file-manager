<?php

// app/models/Batch.php

namespace App\Models;

use DB;
use Eloquent;
use Config;

class Batch extends Eloquent {

	protected $table = "batches";

	public function files() {
		return $this->hasMany('App\Models\File');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function getDates() {
		return array('created_at', 'updated_at', 'deleted_at', 'expiration');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

	public function formattedExpiration() {
		return $this->expiration->format('M j, Y');
	}

}