<?php

	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register all of the routes for an application.
	| It is a breeze. Simply tell Lumen the URIs it should respond to
	| and give it the Closure to call when that URI is requested.
	|
	*/

	$api = app('Dingo\Api\Routing\Router');

	$api->version('v1', function ($api) {
		/**
		 * Authentication route
		 */
		$api->post('auth/login', 'App\Api\v1\AuthController@authenticate');
		$api->post('auth/register', 'App\Api\v1\AuthController@register');
		$api->get('auth/getAuthenticatedUser', 'App\Api\v1\AuthController@getAuthenticatedUser');

		$api->group(['middleware' => 'api.auth', 'prefix' => 'test'], function () use ($api){
			$api->get('/test', 'App\Api\v1\TestController@testCreate');
		});
	});
