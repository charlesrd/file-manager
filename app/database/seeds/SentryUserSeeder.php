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
			'username' => 'udrc',
	        'email'    => 'files@americasmiles.com',
	        'password' => 'dentistry2007#*',
	        'activated' => 1,
	        'upload_folder' => 'udrc'
	    ));
	}

}