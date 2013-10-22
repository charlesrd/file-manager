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
	'uses' => 'BaseController@getIndex'
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
	'getHistory' => 'file_history',
	'postFileDetail' => 'file_detail_post',
	'postBatchDetail' => 'batch_detail_post',
	'getReceived' => 'file_received',
	'postBatchCreate' => 'file_batch_create_post',
	'getDownloadSingle' => 'file_download_single',
	'getDownloadBatch' => 'file_download_batch',
	'postDownloadChecked' => 'file_download_checked',
	'getUpdateTracking' => 'file_update_tracking',
	'postUpdateTracking' => 'file_update_tracking_post'
));

Route::get('search', array(
	'as' => 'search',
	'uses' => 'SearchController@getIndex'
));

Route::post('search', array(
	'before' => 'csrf',
	'as' => 'search_post',
	'uses' => 'SearchController@postResults'
));

Route::get('admin', array(
	'as' => 'admin', 
	'before' => 'auth', 
	'uses' => 'AdminController@getIndex'
));

// Message Routes
Route::controller('message', 'MessageController', array(
	'getIndex' => 'message',
	'postMessage' => 'message_post',
	'getConversation' => 'message_conversation'
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

	Route::get('reset_password', array(
		'as' => 'user_reset_password',
		'uses' => 'UserController@getResetPassword'
	));

	Route::post('reset_password', array(
		'as' => 'user_reset_password_post',
		'uses' => 'UserController@postResetPassword'
	));

});