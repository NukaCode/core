<?php

class ActionsTableSeeder extends Seeder {

    public function run()
    {
    	// Uncomment the below to wipe the table clean before populating
    	DB::table('actions')->truncate();

        $actions = array(
        );

        // Uncomment the below to run the seeder
        DB::table('actions')->insert($actions);
    }

}