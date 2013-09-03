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

// Basic  page routes

// index
Route::get('/', array(
	'as' => 'home', 
	'before' => 'auth', 
	function() {
		return Redirect::route('dashboard');
	}
));

Route::controller('file', 'FileController', array(
	'getIndex' => 'file',
	'getUpload' => 'file_upload',
	'postUpload' => 'file_upload_post',
	'getHistory' => 'file_history'
));

Route::get('message/inbox', array(
	'as' => 'message_inbox',
	function() {
		return Redirect::route('dashboard');
	}
));

Route::get('message/outbox', array(
	'as' => 'message_outbox',
	function() {
		return Redirect::route('dashboard');
	}
));

Route::post('search', array(
	'as' => 'search',
	function() {
		return "TEST!";
	}
));

Route::get('admin', array(
	'as' => 'admin', 
	'before' => 'auth', 
	'uses' => 'AdminController@getIndex'
));

// Routes protected from unauthorized users
//Route::group(array('before' => 'auth'), function() {
	Route::any('dashboard', array(
		'as' => 'dashboard', 
		'uses' => 'DashboardController@getIndex',
		'before' => 'auth'
	));
//});


Route::get('user', array(
	'uses' => 'UserController@getIndex'
));

Route::get('user/logout', array(
	'as' => 'logout', 
	'uses' => 'UserController@getLogout'
));

Route::get('user/login', array(
	'as' => 'login', 
	'uses' => 'UserController@getLogin', 
	'before' => 'guest'
));

Route::post('user/login', array(
	'uses' => 'UserController@postLogin'
));