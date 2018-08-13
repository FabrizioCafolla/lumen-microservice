<?php
	return [
		'Illuminate\Support\Facades\Storage' => 'Storage',

		'App\Facades\CacheFacade' => 'CacheService',
		'App\Facades\ResponseFacade' => 'ResponseService',
		'App\Facades\ApiFacade' => 'ApiService',
		'App\Facades\HelpersFacade' => 'HelpersService',
		'App\Facades\AuthFacade' => 'AuthService',
		'App\Facades\ACLFacade' => 'ACLService',
		'App\Facades\AdminACLFacade' => 'AdminACLService',

		'Tymon\JWTAuth\Facades\JWTAuth' => 'JWTAuth',
		'Tymon\JWTAuth\Facades\JWTFactory' => 'JWTFactory',
	];