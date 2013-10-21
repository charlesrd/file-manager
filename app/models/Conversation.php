<?php

// app/models/Conversation.php

namespace App\Models;
use Eloquent;

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

}