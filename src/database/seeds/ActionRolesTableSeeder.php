<?php

class ActionRolesTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('action_roles')->truncate();

        $action_roles = array(
        );

        // Uncomment the below to run the seeder
        DB::table('action_roles')->insert($action_roles);
    }

}