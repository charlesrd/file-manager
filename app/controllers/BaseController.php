<?php

class BaseController extends Controller {

	public $user = null;

	public function __construct() {
		//Check CSRF token on POST
		$this->beforeFilter('csrf', array('on' => 'post'));
		
		if (Sentry::check()) {
			$this->user = Sentry::getUser();
			View::share('user', $this->user);
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