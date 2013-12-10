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
		return $this->belongsTo('User');
	}

	public function getDates() {
		return array('created_at', 'updated_at', 'deleted_at', 'expires_at');
	}

	public function formattedCreatedAt($for_humans = false) {
		if (!$for_humans) {
			return $this->created_at->format('g:ia \o\n M j, Y');
		} else {
			return $this->created_at->diffForHumans();
		}
	}

	public function formattedExpiresAt($for_humans = false) {
		if (!$for_humans) {
			return $this->expires_at->format('g:ia \o\n M j, Y');
		} else {
			return $this->expires_at->diffForHumans();
		}
	}

	public function formattedShipsAt($for_humans = false) {
        if (!$for_humans) {
            return $this->ships_at->format('M j, Y');
        } else {
            return $this->ships_at->diffForHumans();
        }
    }

}