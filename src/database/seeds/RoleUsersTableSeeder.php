<?php

use Illuminate\Database\Seeder;

class RoleUsersTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('role_users')->truncate();

        $role_users = array(
            array('user_id' => '2bHAJwWCX2', 'role_id' => '4'),
            array('user_id' => 'bmeJBz10K2', 'role_id' => '4'),
        );

        // Uncomment the below to run the seeder
        DB::table('role_users')->insert($role_users);
    }

}