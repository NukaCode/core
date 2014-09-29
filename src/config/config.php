<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Site Details
    |--------------------------------------------------------------------------
    |
    | The name of your site and the icon it should use.  This will show up when
    | twitter is selected as the menu.  Set the siteIcon to null for no icon.
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
	| Included Options: twitter, utopian
	|
	*/
	'menu' => 'utopian',

	/*
	|--------------------------------------------------------------------------
	| Package menus
	|--------------------------------------------------------------------------
	|
	| Add any package created menus you want to enable to this array.
	| Each class listed MUST have a setMenu method which the MenuController will
	| call.
	|
	*/
	'menus' => [
		'NukaCode\Forum\Services\Menu'
	],

	/*
	|--------------------------------------------------------------------------
	| Application Menu
	|--------------------------------------------------------------------------
	|
	| Use the following array to stop core from setting certain classes and keep
	| the Laravel defaults.  This is less likely to be used since Laravel 5+ but
	| it has been left in should it ever be needed.
	|
	*/
	'nonCoreAliases' => array(
	),

);