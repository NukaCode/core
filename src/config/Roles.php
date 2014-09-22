<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Quick Link
	|--------------------------------------------------------------------------
	|
	| This is used to quickly find the ID for the main 4 role levels.  Set these
	| to the ID of the role you want to fill that position.
	|
	*/
	'main' => [
		'guest'     => 1, // General read only user.  Very limited permissions.
		'member'    => 2, // Normal user.
		'admin'     => 3, // Access to control certain aspects of the site.
		'developer' => 4 // Global access to everything the site offers.
	],

	/*
	|--------------------------------------------------------------------------
	| Database population
	|--------------------------------------------------------------------------
	|
	| Create your roles for database seeding here.  They must have the following
	| fields: group, name, keyName, description, priority
	| Sensible defaults have been included for you.
	|
	*/
	'roles' => [
		[
			'group' => 'Site',
			'name' => 'Guest',
			'keyName' => 'GUEST',
			'description' => 'Gives limited read-only abilities in the site.',
			'priority' => 1,
		],
		[
			'group' => 'Site',
			'name' => 'Member',
			'keyName' => 'MEMBER',
			'description' => 'Gives the ability to use all public features of the site.',
			'priority' => 2,
		],
		[
			'group' => 'Site',
			'name' => 'Administrator',
			'keyName' => 'ADMIN',
			'description' => 'Grants access to control over the site and the ability to affect change.',
			'priority' => 3,
		],
		[
			'group' => 'Site',
			'name' => 'Developer',
			'keyName' => 'DEVELOPER',
			'description' => 'Full access to the site and it\'s features.',
			'priority' => 4,
		],
	]
];