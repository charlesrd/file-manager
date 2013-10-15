<?php

// app/models/Message.php

namespace App\Models;

class Message extends \Eloquent {

	public function user() {
		return $this->belongsTo('App\Models\User');
	}

	public function conversation() {
		return $this->belongsTo('App\Models\Conversation');
	}

	public function formattedCreatedAt() {
		return $this->created_at->format('g:ia \o\n M j, Y');
	}

}