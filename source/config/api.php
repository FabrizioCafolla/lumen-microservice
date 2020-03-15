<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 18/01/19
	 * Time: 12.41
	 */
	return [
		'cors' => [
			'standard' => [
				'Access-Control-Allow-Origin'      => env('CORS_ALLOW_ORIGIN'),
				'Access-Control-Allow-Credentials' => env('CORS_ALLOW_CREDENTIALS'),
				'Access-Control-Allow-Methods'     => env('CORS_ALLOW_METHODS'),
				'Access-Control-Allow-Headers'     => env('CORS_ALLOW_HEADERS'),
				'Access-Control-Max-Age'           => env('CORS_MAX_AGE'),
			],

			'production' => [
				//
			],

			'staging' => [
				//
			],

			'develop' => [
				//
			],
		]
	];