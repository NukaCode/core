<?php

$router->group(['namespace' => 'NukaCode\Core\Controllers'], function ($router) {
	$router->get('/admin', [
		'as'   => 'admin.index',
		'uses' => 'AdminController@dashboard'
	]);
});