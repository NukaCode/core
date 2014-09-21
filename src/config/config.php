<?php

return array(

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