<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Current version
	|--------------------------------------------------------------------------
	|
	| The current version of NukaCode\Core the site is using
	*/
	'version' => '2.0.0',

    /*
    |--------------------------------------------------------------------------
    | Site Details
    |--------------------------------------------------------------------------
    |
    | The name of your site and the icon it should use.  This will show up in
    | twitter menues.  Set the siteIcon to null for no icon.
    |
    */

    'siteName' => 'YOUR_SITE',
    'siteIcon' => null,

    /*
    |--------------------------------------------------------------------------
    | Site Theme
    |--------------------------------------------------------------------------
    |
    | The site theme is used to overload the coreOld changes to bootstrap.
    | The available themes are located in nukacode/coreOld/assets/less/themes.
    | You can also make your own in app/assets/less/themes.  Dark is provided
    | as an example.  Use 'default' if you want to use the base style.  Set
    | src to local to use files in app or vendor to use the files from coreOld.
    |
    */
    'theme'     => [
        'style' => 'dark',
        'src'   => 'vendor'
    ],

	/*
	|--------------------------------------------------------------------------
	| Control-Room Site detail
	|--------------------------------------------------------------------------
	|
	| Set this to the site's control room data.  Get this from stygian or riddles
	*/
	'controlRoomDetail' => 'GET_THIS_FROM_CONTROL',

	/*
	|--------------------------------------------------------------------------
	| Application Menu
	|--------------------------------------------------------------------------
	|
	| This variable is used to determine if the site uses the default twitter nav
	| bar or any form of custom menu.  Set this value to the name of the blade
	| located in views/layouts/menus that you wish to use.
	| Options: twitter, utopian
	|
	*/
	'menu' => 'utopian',

	/*
	|--------------------------------------------------------------------------
	| Application Menu
	|--------------------------------------------------------------------------
	|
	| Use the following array to stop coreOld from setting certain classes and keep
	| the laravel defaults.  A common use for thie would be 'User'.
	|
	*/
	'nonCoreAliases' => array(
	),

);