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

		/**
		 * Group routes Admin
		 */
		$api->group(['prefix' => 'admin'], function () use ($api) {});

		/**
		 * Group routes with api jwt authentication
		 */
		$api->group(['middleware' => 'api.auth'], function () use ($api){
			$api->group(['prefix' => 'user'], function () use ($api) {
				$api->get('/{id}', 'App\Api\v1\UserController@show');
				$api->get('/{id}/edit', 'App\Api\v1\UserController@edit');
				$api->put('/{id}', 'App\Api\v1\UserController@update');
				$api->patch('/{id}', 'App\Api\v1\UserController@update');
				$api->delete('/{id}', 'App\Api\v1\UserController@delete');
			});
			$api->get('users/', 'App\Api\v1\UserController@index');

			$api->group(['prefix' => 'post'], function () use ($api) {
				$api->get('/create', 'App\Api\v1\PostController@create');
				$api->post('/', 'App\Api\v1\PostController@store');
				$api->get('/{id}', 'App\Api\v1\PostController@show');
				$api->get('/{id}/edit', 'App\Api\v1\PostController@edit');
				$api->put('/{id}', 'App\Api\v1\PostController@update');
				$api->patch('/{id}', 'App\Api\v1\PostController@update');
				$api->delete('/{id}', 'App\Api\v1\PostController@delete');
			});
			$api->get('posts/', 'App\Api\v1\PostController@index');
		});
	});
