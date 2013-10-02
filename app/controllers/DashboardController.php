<?php

use App\Models\File;

class DashboardController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			$receivedFiles = File::orderBy('created_at', 'DESC')->paginate(10);
			$uploadedFiles = File::where('user_id', '=', $this->user->id)->orderBy('created_at', 'DESC')->paginate(10);

			return View::make('admin.dashboard')->with('receivedFiles', $receivedFiles)->with('uploadedFiles', $uploadedFiles);
		} else if ($this->user->hasAccess('users')) {
			$uploadedFiles = File::where('user_id', '=', $this->user->id)->orderBy('created_at', 'DESC')->paginate(10);

			return View::make('user.dashboard')->with('uploadedFiles', $uploadedFiles);
		}
	}

}