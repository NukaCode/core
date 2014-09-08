<?php

Route::group(['namespace' => '\\NukaCode\Core\Controllers'], function () {
//Route::group([], function () {
	/********************************************************************
	 * Sessions
	 *******************************************************************/
	Route::get('register', [
		'as'   => 'register',
		'uses' => 'SessionController@getRegister'
	]);
	Route::post('register', [
		'as'   => 'register',
		'uses' => 'SessionController@postRegister'
	]);
	Route::get('login', [
		'as'   => 'login',
		'uses' => 'SessionController@getLogin'
	]);
	Route::post('login', [
		'as'   => 'login',
		'uses' => 'SessionController@postLogin'
	]);
	Route::get('/collapse/{target}', [
		'as'   => 'collapse',
		'uses' => 'SessionController@collapse'
	]);
	Route::post('login', [
			'as'   => 'login',
			'uses' => 'SessionController@postLogin'
		]
	);
	Route::get('logout', [
		'as' => 'logout',
		function () {
			Auth::logout();

			if (Session::has('activeUser')) {
				Session::forget('activeUser');
			}

			return Redirect::to('/')->with('message', 'You have successfully logged out.');
		}
	]);

	/********************************************************************
	 * General
	 *******************************************************************/
	Route::get('/memberlist', [
		'as'   => 'memberlist',
		'uses' => 'UserController@memberlist'
	]);

	/********************************************************************
	 * User Details
	 *******************************************************************/
	Route::group(['prefix' => 'user', 'before' => 'auth'], function () {
		Route::get('/datatable', [
			'as'   => 'user.datatable',
			'uses' => 'UserController@datatable'
		]);
		Route::get('/account', [
			'as'   => 'user.account',
			'uses' => 'UserController@account'
		]);
		Route::get('/view/{id?}', [
			'as'   => 'user.view',
			'uses' => 'UserController@view'
		]);
		Route::get('/profile', [
			'as'   => 'user.profile',
			'uses' => 'UserController@getProfile'
		]);
		Route::post('/profile', [
			'as'   => 'user.profile',
			'uses' => 'UserController@postProfile'
		]);
		Route::get('/avatar', [
			'as'   => 'user.avatar',
			'uses' => 'UserController@getAvatar'
		]);
		Route::post('/avatar', [
			'as'   => 'user.avatar',
			'uses' => 'UserController@postAvatar'
		]);
		Route::get('/preferences', [
			'as'   => 'user.preferences',
			'uses' => 'UserController@getPreferences'
		]);
		Route::post('/preferences', [
			'as'   => 'user.preferences',
			'uses' => 'UserController@postPreferences'
		]);
		Route::get('/change-password', [
			'as'   => 'user.password.change',
			'uses' => 'UserController@getChangePassword'
		]);
		Route::post('/change-password', [
			'as'   => 'user.password.change',
			'uses' => 'UserController@postChangePassword'
		]);
	});

	/********************************************************************
	 * Access to the dev panels
	 *******************************************************************/
	Route::group(['prefix' => 'admin', 'before' => 'auth|permission:SITE_ADMIN'], function () {
		Route::group(['prefix' => 'site', 'namespace' => 'Admin'], function () {
			Route::get('/theme', [
				'as'   => 'admin.site.theme',
				'uses' => 'SiteController@getTheme'
			]);
			Route::post('/theme', [
				'as'   => 'admin.site.theme',
				'uses' => 'SiteController@postTheme'
			]);
			Route::get('/', [
				'as'   => 'admin.site',
				'uses' => 'SiteController@index'
			]);
		});
		Route::group(['prefix' => 'user', 'namespace' => 'Admin'], function () {
			Route::get('/user-customize', [
				'as'   => 'admin.user.customize',
				'uses' => 'UserController@userCustomize'
			]);
			Route::get('/role-customize', [
				'as'   => 'admin.user.role',
				'uses' => 'UserController@roleCustomize'
			]);
			Route::get('/action-customize', [
				'as'   => 'admin.user.action',
				'uses' => 'UserController@actionCustomize'
			]);
			Route::get('/preference-customize', [
				'as'   => 'admin.user.preference',
				'uses' => 'UserController@preferenceCustomize'
			]);
			Route::get('/', [
				'as'   => 'admin.user',
				'uses' => 'UserController@index'
			]);
		});
		Route::group(['prefix' => 'edit', 'namespace' => 'Admin\Edit'], function () {
			Route::get('user/{id}', [
				'as'   => 'admin.edit.user',
				'uses' => 'UserController@getIndex'
			]);
			Route::post('user/{id}', [
				'as'   => 'admin.edit.user',
				'uses' => 'UserController@postIndex'
			]);
			Route::get('role/{id}', [
				'as'   => 'admin.edit.role',
				'uses' => 'RoleController@getIndex'
			]);
			Route::post('role/{id}', [
				'as'   => 'admin.edit.role',
				'uses' => 'RoleController@postIndex'
			]);
			Route::get('action/{id}', [
				'as'   => 'admin.edit.action',
				'uses' => 'ActionController@getIndex'
			]);
			Route::post('action/{id}', [
				'as'   => 'admin.edit.action',
				'uses' => 'ActionController@postIndex'
			]);
			Route::get('preference/{id}', [
				'as'   => 'admin.edit.preference',
				'uses' => 'PreferenceController@getIndex'
			]);
			Route::post('preference/{id}', [
				'as'   => 'admin.edit.preference',
				'uses' => 'PreferenceController@postIndex'
			]);
		});
		Route::get('/', [
			'as'   => 'admin',
			'uses' => 'AdminController@getIndex'
		]);
	});
});

