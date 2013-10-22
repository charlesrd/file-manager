<?php

use App\Models\File;
use App\Models\Batch;

class DashboardController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			$data = File::getFiles($this->user->id);
                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  return View::make('admin.dashboard')->with('data', $data)->with('batches', $batches);
		} else if ($this->user->hasAccess('users')) {
			$data = File::getFiles($this->user->id);
                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  return View::make('user.dashboard')->with('data', $data)->with('batches', $batches);
		}
	}

}