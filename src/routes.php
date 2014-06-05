<?php

/********************************************************************
 * Authentication
 *******************************************************************/
Route::get(
    'register',
    [
        'as' => 'register',
        'uses' => 'NukaCode\Core\Controllers\SessionController@getRegister'
    ]
);
Route::post(
    'register',
    'NukaCode\Core\Controllers\SessionController@postRegister'
);
Route::get(
    'login',
    [
        'as' => 'login',
        'uses' => 'NukaCode\Core\Controllers\SessionController@getLogin'
    ]
);
Route::post('login', 'NukaCode\Core\Controllers\SessionController@postLogin');
Route::get('logout', function () {
    Auth::logout();

    return Redirect::to('/')->with('message', 'You have successfully logged out.');
});

/********************************************************************
 * General
 *******************************************************************/
// Route::get('memberlist', ['as' => 'memberlist', 'uses' => 'NukaCode\Core\Controllers\UserController@getMemberlist']);
Route::group(['before' => 'auth'], function () {
    // Route::controller('user', 'NukaCode\Core\Controllers\UserController');
});

/********************************************************************
 * Access to the dev panels
 *******************************************************************/
Route::group(['prefix' => 'admin', 'before' => 'auth|permission:SITE_ADMIN'], function () {
    // Route::controller('users', 'NukaCode\Core\Controllers\Admin\UserController');
    // Route::controller('message', 'NukaCode\Messaging\Controllers\Admin\MessageController');
});
