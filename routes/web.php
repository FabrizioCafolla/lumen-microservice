<?php


	$router->group(['prefix' => 'api/v1'], function () use ($router) {
		/**
		 * Authentication route
		 */
		$router->group(['prefix' => '/auth'], function () use ($router) {
			$router->post('login', 'v1\AuthController@authenticate');
			$router->post('register', 'v1\AuthController@register');
			$router->get('getAuthenticatedUser', 'v1\AuthController@getAuthenticatedUser');
			$router->get('invalidate', 'v1\AuthController@invalidate');
			$router->get('refresh', 'v1\AuthController@refresh');
		});
	});