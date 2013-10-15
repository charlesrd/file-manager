<?php

use App\Models\File;
use App\Models\Conversation;

class BaseController extends Controller {

	public $user;
	public $afterCutoff = false;

	public function __construct() {
		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

        $now = Carbon::now();

        // Check the current request time and compare it against upload time set in config.app
        // If the current request time is on or past the upload cutoff time, set to true
        if ($now->hour >= Config::get('app.file_upload_cutoff_time_CST')) {
            $this->afterCutoff = true;
            View::share('afterCutoff', true);
        } else {
        	$this->afterCutoff = false;
        	View::share('afterCutoff', false);
        }
		
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
			View::share('user', $this->user);

			if ($this->user->hasAccess('admin')) {
				$filesNotDownloaded = File::where('download_status', '=', '0');
				$conversations = Conversation::all();

				View::share('filesNotDownloaded', $filesNotDownloaded);
				View::share('conversations', $conversations);
			}
		} else {
			$this->user = null;
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}