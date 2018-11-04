<?php
	return [
		/*
		 * Providers always load in Core
		 */
		'global' => [
			'core' => \Core\Providers\CoreServiceProvider::class,
			'auth' => \Core\Providers\AuthServiceProvider::class,
			'graphql' => \Core\Providers\GraphQLServiceProvider::class,
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
		],

		'alias' => [],
	];