<?php

/********************************************************************
 * Authentication
 *******************************************************************/
Route::get('register', [
    'as'   => 'register',
    'uses' => 'NukaCode\Core\Controllers\SessionController@getRegister'
]);
Route::post('register', [
    'as'   => 'register',
    'uses' => 'NukaCode\Core\Controllers\SessionController@postRegister'
]);
Route::get('login', [
    'as'   => 'login',
    'uses' => 'NukaCode\Core\Controllers\SessionController@getLogin'
]);
Route::post('login', [
        'as'   => 'login',
        'uses' => 'NukaCode\Core\Controllers\SessionController@postLogin'
    ]
);
Route::get('logout', function () {
    Auth::logout();

    if (Session::has('activeUser')) {
        Session::forget('activeUser');
    }

    return Redirect::to('/')->with('message', 'You have successfully logged out.');
});

/********************************************************************
 * General
 *******************************************************************/
Route::get('memberlist', [
    'as'   => 'memberlist',
    'uses' => 'NukaCode\Core\Controllers\UserController@getMemberlist'
]);
Route::group(['before' => 'auth'], function () {
    Route::controller('user', 'NukaCode\Core\Controllers\UserController');
});

/********************************************************************
 * Access to the dev panels
 *******************************************************************/
Route::group(['prefix' => 'admin', 'namespace' => 'NukaCode\Core\Controllers', 'before' => 'auth|permission:SITE_ADMIN'], function () {
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
    Route::controller('user', 'Admin\UserController');
    Route::controller('site', 'Admin\SiteController');
    Route::get('/', [
        'as'   => 'admin',
        'uses' => 'AdminController@getIndex'
    ]);
});

