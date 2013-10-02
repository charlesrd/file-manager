<?php

class SentryUserSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->delete();

		Sentry::getUserProvider()->create(array(
	        'email'    => 'colin@americasmiles.com',
	        'password' => 'test12345',
	        'activated' => 1,
	        'upload_folder' => 'colinams'
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'superuser@test.com',
	        'password' => 'test12345',
	        'activated' => 1,
	        'upload_folder' => 'superuser'
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'admin@test.com',
	        'password' => 'test12345',
	        'activated' => 1,
	        'upload_folder' => 'admintest'
	    ));

	    Sentry::getUserProvider()->create(array(
	    	'email'    => 'user@test.com',
	        'password' => 'test12345',
	        'activated' => 1,
	        'upload_folder' => 'usertest'
	    ));
	}

}