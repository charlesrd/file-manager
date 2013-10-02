<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

	public function files() {
		return $this->hasMany('App\Models\File');
	}

	public function conversations() {
		return $this->belongsToMany('App\Models\Conversation', 'users_conversations');
	}

	public function messages() {
		return $this->hasMany('App\Models\Message');
	}

}