<?php

// app/models/Conversation.php

namespace App\Models;

class Conversation extends \Eloquent {

	public function users() {
		return $this->belongsToMany('App\Models\User', 'users_conversations');
	}

	public function messages() {
		return $this->hasMany('App\Models\User');
	}

}