<?php

class Preferences_usersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('preferences_users')->truncate();

		$preferences_users = array(
			array('user_id' => '2bHAJwWCX2', 'preference_id' => 1, 'value' => 'gravatar'),
			array('user_id' => 'bmeJBz10K2', 'preference_id' => 1, 'value' => 'gravatar'),
			array('user_id' => '2bHAJwWCX2', 'preference_id' => 2, 'value' => 'yes'),
			array('user_id' => 'bmeJBz10K2', 'preference_id' => 2, 'value' => 'yes'),
		);

		// Uncomment the below to run the seeder
		DB::table('preferences_users')->insert($preferences_users);
	}

}
