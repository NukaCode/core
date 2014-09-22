<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('roles')->truncate();

		// These are set in the config so the individual site can override the defaults when desired.
        $roles = Config::get('core::roles.roles');

        // Uncomment the below to run the seeder
        DB::table('roles')->insert($roles);
    }

}