<?php

class SentryUserGroupSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_groups')->delete();

		//$userUser = Sentry::getUserProvider()->findByLogin('user@test.com');
		$adminUser = Sentry::getUserProvider()->findByLogin('udrc');
		//$superUser = Sentry::getUserProvider()->findByLogin('superuser@test.com');

		$userGroup = Sentry::getGroupProvider()->findByName('Users');
		$adminGroup = Sentry::getGroupProvider()->findByName('Admins');
		//$superUserGroup = Sentry::getGroupProvider()->findByName('Super Admins');

	    // Assign the groups to the users
	    // $userUser->addGroup($userGroup);
	    $adminUser->addGroup($userGroup);
	    $adminUser->addGroup($adminGroup);
	    // $superUser->addGroup($userGroup);
	    // $superUser->addGroup($adminGroup);
	    // $superUser->addGroup($superUserGroup);
	}

}