<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 03/08/18
	 * Time: 14.09
	 */

	/**
	 * Alias Facades Storage
	 */
	if (!class_exists('Storage')) {
		class_alias('Illuminate\Support\Facades\Storage', 'Storage');
	}

	/**
	 * Alias ResponseService
	 */
	if (!class_exists('ResponseService')) {
		class_alias('App\Facades\ResponseFacade', 'ResponseService');
	}

	/**
	 * Alias ApiService
	 */
	if (!class_exists('ApiService')) {
		class_alias('App\Facades\ApiFacade', 'ApiService');
	}

	/**
	 * Alias ACLService
	 */
	if (!class_exists('ACLService')) {
		class_alias('App\Facades\ACLFacade', 'ACLService');
	}

	/**
	 * Alias AdminACLService
	 */
	if (!class_exists('AdminACLService')) {
		class_alias('App\Facades\AdminACLFacade', 'AdminACLService');
	}

	/**
	 * Alias HelpersService
	 */
	if (!class_exists('HelpersService')) {
		class_alias('App\Facades\HelpersFacade', 'HelpersService');
	}

	/**
	 * Alias UserAuthService
	 */
	if (!class_exists('UserAuthService')) {
		class_alias('App\Facades\UserAuthFacade', 'UserAuthService');
	}

	/**
	 * Alias JwtAuth
	 */
	if (!class_exists('JWTAuth')) {
		class_alias('Tymon\JWTAuth\Facades\JWTAuth', 'JWTAuth');
	}

	/**
	 * Alias JwtAuth
	 */
	if (!class_exists('JWTFactory')) {
		class_alias('Tymon\JWTAuth\Facades\JWTFactory', 'JWTFactory');
	}