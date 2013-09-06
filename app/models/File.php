<?php

// app/models/File.php

namespace App\Models;

class File extends \Eloquent {

	public function user() {
		return $this->hasOne('User');
	}

}