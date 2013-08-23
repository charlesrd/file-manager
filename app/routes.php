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

Route::get('about', function() {
	$version = '25 million';
	return View::make('public.about', compact("version"));
});

Route::get('help', array(
	'as' => 'help',
	'uses' => 'HelpController@getIndex'
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

Route::group(array('domain' => '{user}.amdsti.dev'), function() {
	Route::get('about', function() {
		$version = $user;
		return View::make('public.about', compact("version"));
	});
});

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





// Testing routes
Route::group(array('domain' => '{account}.amsdti.dev'), function() {
	Route::get('/', function($account) {
		return View::make('public.about', compact("account"));
	});
});