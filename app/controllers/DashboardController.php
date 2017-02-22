<?php

use App\Models\File;
use App\Models\Batch;

class DashboardController extends BaseController {

	public function getIndex() {
		if ($this->user->hasAccess('superuser')) {
			return View::make('superuser.dashboard');
		} else if ($this->user->hasAccess('admin')) {
			// $data = File::getFiles($this->user->id);
                  
                  $data = File::getSearchFiles('.', $this->user->id);
                  

                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  return View::make('admin.dashboard3')->with('data', $data)->with('batches', $batches);
		} else if ($this->user->hasAccess('users')) {
			// $data = File::getFiles($this->user->id);

                  error_log("The user was found. About to load the dashboard...", 0);

                  if ($this->user->id == 200)
                  {
                        $data = File::getSearchFiles('.', 200);
                  }
                  else
                  {
                        $data = File::getSearchFiles('.', $this->user->id);
                  }

                  
                  $batches = $data['batches'];
                  $data['today_filecount'] = File::todayFileCount($this->user->id);
                  $data['weekly_filecount'] = File::weeklyFileCount($this->user->id);
                  $data['averageXDays_filecount'] = File::averageXDays($this->user->id);

                  if ($this->user->id == 200)
                  {
                        return View::make('user.dashboard3')->with('data', $data)->with('batches', $batches);
                  }
                  else
                  {
                        return View::make('user.dashboard3')->with('data', $data)->with('batches', $batches);
                  }
		}
	}

}