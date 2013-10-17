<?php

use App\Models\File;
use App\Models\Batch;

class DashboardController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			$data = File::getReceivedFiles();
            $batches = Batch::orderBy('created_at', 'DESC')->take(10)->get();
            $data['today_filecount'] = File::todayFileCount();

            return View::make('admin.dashboard')->with('data', $data)->with('batches', $batches);
		} else if ($this->user->hasAccess('users')) {
			$files = File::where('user_id', '=', $this->user->id)->orderBy('created_at', 'DESC')->paginate(Config::get('app.pagination_items_per_page'));

			return View::make('user.dashboard')->with('files', $files);
		}
	}

}