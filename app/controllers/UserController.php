<?php

class UserController extends BaseController {

	public $restful = true;
	public $layout = 'layouts.dashboard_no_sidebar';

	public function getIndex() {
		$this->layout->title = 'User Login';
		$this->layout->content = View::make('public.login');
	}

	public function getLogin() {
		$this->layout->title = 'User Login';
		$this->layout->content = View::make('public.login');
	}

	public function postLogin() {
		// grab all posted inputs from login form
		$inputs = Input::all();

		// define validation rules
        $rules = array(
            'user_email' => 'required|email',
            'user_password' => 'required'
        );

        // create new Validator instance using inputs and rules
        $validation = Validator::make($inputs, $rules);

        // run validation check
        if ($validation->fails()) {
            return Redirect::route('login')->withErrors($validation)->withInput();
        } else {
        	// try to log a user in
        	try {
        		$user = Sentry::getUserProvider()->findByLogin($inputs['user_email']);

        		$userCredentials = array(
        			'email' => $inputs['user_email'],
        			'password' => $inputs['user_password']
        		);

        		$user = Sentry::authenticate($userCredentials, true);
        	// uh oh, we couldn't find the user
        	} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
        		Session::flash('login_errors', true);
        		return Redirect::route('login')->withErrors($validation)->withInput(Input::except('user_password'));
        	}

        	// User login was successful, let's go to the dashboard!
            return Redirect::intended('dashboard');
        }
	}

	public function getLogout() {
		// destroy user session to log them out
		Sentry::logout();
		// redirect to homepage
		return Redirect::route('home');
	}

}