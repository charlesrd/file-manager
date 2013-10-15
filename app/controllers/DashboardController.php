<?php

use App\Models\File;

class DashboardController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			$receivedFiles = File::orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));
			$uploadedFiles = File::where('user_id', '=', $this->user->id)->orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));

			return View::make('admin.dashboard')->with('receivedFiles', $receivedFiles)->with('uploadedFiles', $uploadedFiles);
		} else if ($this->user->hasAccess('users')) {
			$files = File::where('user_id', '=', $this->user->id)->orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));

			return View::make('user.dashboard')->with('files', $files);
		}
	}

}