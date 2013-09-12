<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Index route
Route::get('/', array(
	'as' => 'home',
	function() {
		if (Sentry::getUser()) {
			return Redirect::route('dashboard');
		} else {
			return View::make('public.landing');
		}
	}
));

// Dashboard route
Route::any('dashboard', array(
	'before' => 'auth',
	'as' => 'dashboard',
	'uses' => 'DashboardController@getIndex'
));

// File Routes
Route::controller('file', 'FileController', array(
	'getIndex' => 'file',
	'getUpload' => 'file_upload',
	'postUpload' => 'file_upload_post',
	'getHistory' => 'file_history'
));

Route::post('search', array(
	'before' => 'csrf',
	'as' => 'file_search',
	'uses' => 'SearchController@getResults'
));

Route::get('admin', array(
	'as' => 'admin', 
	'before' => 'auth', 
	'uses' => 'AdminController@getIndex'
));

// Message Routes
Route::controller('message', 'MessageController', array(
	'getIndex' => 'message',
	'getInbox' => 'message_inbox',
	'getOutbox' => 'message_outbox'
));

// User Routes
Route::group(array('prefix' => 'user'), function() {

	Route::get('/', array(
		'as' => 'user',
		'uses' => 'UserController@getIndex'
	));

	Route::get('login', array(
		'as' => 'user_login',
		'before' => 'guest',
		'uses' => 'UserController@getLogin'
	));

	Route::post('login', array(
		'uses' => 'UserController@postLogin'
	));

	Route::get('logout', array(
		'as' => 'user_logout',
		'before' => 'auth',
		'uses' => 'UserController@getLogout'
	));

	Route::get('resetpassword', array(
		'as' => 'user_resetpassword',
		'before' => 'auth',
		'uses' => 'UserController@getResetPassword'
	));

});