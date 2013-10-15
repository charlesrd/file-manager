<?php

// app/models/Conversation.php

namespace App\Models;
use Eloquent;

class Conversation extends Eloquent {

	public function users() {
		return $this->belongsToMany('App\Models\User', 'users_conversations')->withPivot('read');
	}

	public function messages() {
		return $this->hasMany('App\Models\Message');
	}

}