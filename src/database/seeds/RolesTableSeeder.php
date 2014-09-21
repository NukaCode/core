<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('roles')->truncate();

        $roles = array(
            array(
                'group' => 'Site',
                'name' => 'Guest',
                'keyName' => 'GUEST',
                'description' => 'Gives limited read-only abilities in the site.',
                'priority' => 1,
            ),
            array(
                'group' => 'Site',
                'name' => 'Member',
                'keyName' => 'MEMBER',
                'description' => 'Gives the ability to use all public features of the site.',
                'priority' => 2,
            ),
            array(
                'group' => 'Site',
                'name' => 'Administrator',
                'keyName' => 'ADMIN',
                'description' => 'Grants access to control over the site and the ability to affect change.',
                'priority' => 3,
            ),
            array(
                'group' => 'Site',
                'name' => 'Developer',
                'keyName' => 'DEVELOPER',
                'description' => 'Full access to the site and it\'s features.',
                'priority' => 4,
            ),
        );

        // Uncomment the below to run the seeder
        DB::table('roles')->insert($roles);
    }

}