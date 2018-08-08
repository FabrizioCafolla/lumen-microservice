<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 03/08/18
	 * Time: 14.09
	 */

	/**
	 * Alias PermissionService
	 */
	if (!class_exists('PermissionService')) {
		class_alias('App\Services\PermissionService', 'PermissionService');
	}

	/**
	 * Alias ApiService
	 */
	if (!class_exists('ApiService')) {
		class_alias('App\Services\ApiService', 'ApiService');
	}

	/**
	 * Alias ResponseService
	 */
	if (!class_exists('ResponseService')) {
		class_alias('App\Services\ResponseService', 'ResponseService');
	}

	/**
	 * Alias HelpersService
	 */
	if (!class_exists('HelpersService')) {
		class_alias('App\Services\HelpersService', 'HelpersService');
	}

	/**
	 * Alias UserAuthService
	 */
	if (!class_exists('UserAuthService')) {
		class_alias('App\Services\Auth\UserAuthService', 'UserAuthService');
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