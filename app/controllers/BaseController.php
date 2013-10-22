<?php

use App\Models\File;
use App\Models\Conversation;

class BaseController extends Controller {

	public $user = null;
	public $afterCutoff = false;
	public $beforeBeginningOfDay = false;
	public $unread_conversation_count = null;

	public function __construct() {
		//parent::__construct();
		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

        $now = Carbon::now();

        // Check the current request time and compare it against upload time set in config.app
        // If the current request time is on or past the upload cutoff time, set to true
        if ($now->hour >= Config::get('app.file_upload_cutoff_hour_CST') && $now->hour < Config::get('app.end_of_day_hour_CST')) {
	        $this->afterCutoff = true;
	    } else {
	    	$this->afterCutoff = false;
	    }

	    View::share('afterCutoff', $this->afterCutoff);
		
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
			View::share('user', $this->user);
			View::share('unread_conversation_count', Conversation::getUnreadConversations($this->user->id)->count());

			if ($this->user->hasAccess('admin')) {
				$filesNotDownloaded = File::where('download_status', '=', '0');
				$conversations = Conversation::all();

				View::share('filesNotDownloaded', $filesNotDownloaded);
				View::share('conversations', $conversations);
			}
		}
	}

	public function getIndex() {
		if (Sentry::getUser()) {
			return Redirect::route('dashboard');
		} else {
			return View::make('public.landing');
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