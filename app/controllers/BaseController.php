<?php

use App\Models\File;
use App\Models\Conversation;

class BaseController extends Controller {

	public $user = null;

	public $upload_cutoff = 0; // 0 = no cutoff set, 1 = soft cutoff set, 2 = hard cutoff set
	public $unread_conversation_count = null;
	

	public function __construct() {
		//parent::__construct();
		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));

        $now = Carbon::now();

        // Determine whether or not the current time is between the soft cutoff 
        if ($now->hour >= Config::get('app.file_upload_soft_cutoff_hour') && $now->hour < Config::get('app.file_upload_hard_cutoff_hour') + 1) {
        	// it's soft cutoff time
	        $this->upload_cutoff = 1;
	    } else if ($now->hour >= Config::get('app.file_upload_soft_cutoff_hour') + 1 && $now->hour <= Config::get('app.end_of_day_hour')) {
	    	// it's hard cutoff time
	    	$this->upload_cutoff = 2;
	    }

	    View::share('upload_cutoff', $this->upload_cutoff);
		
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