<?php

class UserController extends BaseController {

	public function getIndex() {
		return Redirect::route('user_login');
	}

	public function getLogin() {
		return View::make('public.landing');
	}

	public function postLogin() {
		// grab all posted inputs from login form
		$inputs = Input::all();

		// define validation rules
        $rules = array(
            'user_username' => 'required',
            'user_password' => 'required'
        );

        // create new Validator instance using inputs and rules
        $validation = Validator::make($inputs, $rules);

        // run validation check
        if ($validation->fails()) {
            return Redirect::route('user_login')->withErrors($validation)->withInput();
        } else {
            // check if superuser from amsdti table only, used for SUPER account
            // bypasses all checks below and just logs in super user
            try {
                $superuser = Sentry::findUserByCredentials(array(
                    'username' => $inputs['user_username'],
                    'password' => $inputs['user_password']
                ));

                $this->user = Sentry::login($superuser, isset($inputs['remember']));
                return Redirect::intended('dashboard');
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                // check and see if a DLP user exists with that lab login
                $dlp_user = DB::connection('dentallabprofile')->table('labprofile')->where('labLogin', '=', $inputs['user_username'])->first();
                DB::reconnect('amsdti');

                if (!$dlp_user) {
                    Session::flash('login_errors', true);
                    return Redirect::route('user_login')->withInput(Input::except('user_password'));
                }

                $dlp_password = Hash::make($dlp_user->labPassword);

                if (($dlp_user && Hash::check($inputs['user_password'], $dlp_password))) {
                    // try to log a user in
                    try {
                        $this->user = Sentry::getUserProvider()->findByLogin($inputs['user_username']);
                    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                        if (!$this->user) {
                            try {
                                $this->user = Sentry::createUser(array(
                                    'lab_id' => $dlp_user->labID,
                                    'lab_name' => $dlp_user->labName,
                                    'username' => $dlp_user->labLogin,
                                    'email'    => $dlp_user->labEmail,
                                    'password' => Hash::make($dlp_user->labPassword),
                                    'lab_contact' => $dlp_user->labContact,
                                    'activated' => 1,
                                    'upload_folder' => $dlp_user->labLogin . str_random(20)
                                ));

                                $createUserGroup = Sentry::findGroupById(1);

                                $this->user->addGroup($createUserGroup);
                            } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                                return App::abort('500', 'There was an error converting your DentalLabProfile.com credentials.  If this is your first time logging in, please contact us to resolve the problem.');
                            }
                        }
                    }

                    Sentry::login($this->user, isset($inputs['remember']));

                    // User login was successful, let's go to the dashboard!
                    return Redirect::intended('dashboard');
                } else {
                    Session::flash('login_errors', true);;
                    return Redirect::route('user_login')->withInput(Input::except('user_password'));
                }
            }

        }
	}

	public function getLogout() {
		// destroy user session to log them out
		Sentry::logout();
		// redirect to homepage
		return Redirect::route('home');
	}

    public function getResetPassword() {
        return View::make('public.user.reset_password');
    }

    public function postResetPassword() {
        // grab all posted inputs from login form
        $inputs = Input::all();

        // define validation rules
        $rules = array(
            'lab_email' => 'required|email'
        );

        $messages = array(
            'lab_email.required' => 'Please enter the email address linked to your DentalLabProfile account.',
            'lab_email.email' => 'Please enter a correctly formatted email.'
        );

        // create new Validator instance using inputs and rules
        $validation = Validator::make($inputs, $rules, $messages);

        // run validation check
        if ($validation->fails()) {
            return Redirect::route('user_reset_password')->withErrors($validation)->withInput();
        } else {
            $emptyModelInstance = Sentry::getUserProvider()->getEmptyUser();
            $user = $emptyModelInstance->where('email', '=', Input::get('email'))->first();

            if (!$user) {
                return View::make('public.user.reset_password')->with('formError', 'User with email <code>' . Input::get('lab_email') . '</code> not found.');
            } else {
                $data = array(
                    'lab_name' => $user->dlp_user->labName,
                    'lab_email' => $user->email,
                    'password_reset_code' => $user->getResetPasswordCode() 
                );
                Mail::send('emails.auth.reset_password', $data, function($message) use ($user) {
                    $message->from(Config::get('app.noreply_email'), Config::get('app.company_name'));
                    $message->to($data['lab_email'], $data['lab_name']);
                });
            }

        }
    }

}