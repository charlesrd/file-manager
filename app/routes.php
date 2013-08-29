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

Route::controller('file', 'FileController');

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