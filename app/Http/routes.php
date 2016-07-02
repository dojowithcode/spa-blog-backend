<?php

Route::group(['middleware' => 'api'], function() {

	Route::post('auth/singup', [
		'uses'	=> 'AuthController@signUp'
	]);

	Route::post('auth/signin', [
		'uses'	=> 'AuthController@signin'
	]);

	Route::group(['middleware' => 'jwt.auth'], function() {

		Route::get('/user', [
			'uses'	=> 'UserController@index'
		]);

	});
});