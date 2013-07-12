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
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'test@test.com',
	        'password' => 'test12345',
	        'activated' => 1,
	    ));

	    Sentry::getUserProvider()->create(array(
	        'email'    => 'casey@caseysceramicarts.com',
	        'password' => 'test12345',
	        'activated' => 1,
	    ));
	}

}