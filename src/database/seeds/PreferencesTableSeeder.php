<?php

class PreferencesTableSeeder extends Seeder {

    public function run()
    {
        // Uncomment the below to wipe the table clean before populating
        DB::table('preferences')->truncate();

        $preferences = array(
            array(
                'name'        => 'Avatar to display',
                'keyName'     => 'AVATAR',
                'value'       => 'avatar|gravatar|none',
                'default'     => 'gravatar',
                'display'     => 'select',
                'description' => 'Select what to display for yourself.  You can chose between an uploaded avatar, your gravatar image or nothing.',
            ),
            array(
                'name'        => 'Show your email address to others',
                'keyName'     => 'SHOW_EMAIL',
                'value'       => 'yes|no',
                'default'     => 'yes',
                'display'     => 'select',
                'description' => 'This will allow other users to see your email address.',
            ),
            array(
                'name'        => 'Site Menu',
                'keyName'     => 'SITE_MENU',
                'value'       => 'twitter|utopian',
                'default'     => 'utopian',
                'display'     => 'select',
                'description' => 'Determines the menu bar at the top of the page.',
            ),
            array(
                'name'        => 'Popover interaction',
                'keyName'     => 'POPOVER_TYPE',
                'value'       => 'click|hover|focus',
                'default'     => 'click',
                'display'     => 'select',
                'description' => 'How you would like to interact with popover text.',
            ),
            array(
                'name'        => 'Alert location',
                'keyName'     => 'ALERT_LOCATION',
                'value'       => 'top-left|top|top-right|bottom-right|bottom|bottom-left',
                'default'     => 'top',
                'display'     => 'select',
                'description' => 'Select where you would like the alert box to appear.',
            ),
            array(
                'name'        => 'Chat Timestamps',
                'keyName'     => 'CHAT_TIMESTAMPS',
                'value'       => 'on|off',
                'default'     => 'on',
                'display'     => 'select',
                'description' => 'Set whether to see chat timestamps.',
            ),
        );

        // Uncomment the below to run the seeder
        DB::table('preferences')->insert($preferences);
    }

}
