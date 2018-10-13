<?php
	return [
		/*
		 * Providers always load in App
		 */
		'global' => [
			'core' => \App\Providers\CoreServiceProvider::class,
			'auth' => \App\Providers\AuthServiceProvider::class,
			'app' => \App\Providers\AppServiceProvider::class,
		],

		/*
		 * Providers load when env is production
		 */
		'production' => [
			//
		],

		/*
		 * Providers load when env is local
		 */
		'local' => [
			//
		]
	];