<?php


	$router->group(['prefix' => 'api/v1'], function () use ($router) {
		/**
		 * Authentication route
		 */
		$router->group(['prefix' => '/auth'], function () use ($router) {
			$router->post('login', 'v1\AuthController@authenticate');
			$router->post('register', 'v1\AuthController@register');
			$router->get('authenticated',  'v1\AuthController@getAuthenticatedUser');
			$router->get('invalidate', 'v1\AuthController@invalidate');
			$router->get('refresh','v1\AuthController@refresh');
		});

		/**
		 * Users routes with jwt middleware
		 */
		$router->group(['middleware' => 'api.jwt', 'prefix' => 'users'], function () use ($router) {
			$router->get('/', 'v1\UserController@index');
			$router->get('/{id}', 'v1\UserController@show');

			$router->put('/{id}', 'v1\UserController@update');
			$router->put('/{id}/password', 'v1\UserController@updatePassword');
			$router->delete('/{id}', 'v1\UserController@delete');
		});

		/**
		 * Posts routes with jwt middleware
		 */
		$router->group(['middleware' => 'api.jwt', 'prefix' => 'posts'], function () use ($router) {
			$router->get('/', 'v1\PostController@index');
			$router->get('/{postId}', 'v1\PostController@show');

			$router->post('/store', 'v1\PostController@store');
			$router->put('/{postId}', 'v1\PostController@update');
			$router->delete('/{postId}', 'v1\PostController@delete');
		});
	});