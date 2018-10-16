<?php

	namespace App\Api\v1;

	use Laravel\Lumen\Routing\Controller as BaseController;

	/**
	 * Class ApiBaseController
	 * @package App\Api\v1
	 */
	class ApiBaseController extends BaseController
	{
		/**
		 * @var ApiService
		 */
		public $api;

		/**
		 * @var ResponseService
		 */
		public $response;

		/**
		 * @var AuthService
		 */
		public $auth;

		/**
		 * @var ACLService
		 */
		public $acl;

		/**
		 * @var Cache
		 */
		public $cache;

		/**
		 * @var Log
		 */
		public $log;

		/**
		 * @var Log
		 */
		public $helpers;

		public function __construct()
		{
			$this->api = app('service.api');
			$this->response = app('service.response');
			$this->auth = app('service.auth');
			$this->acl = app('service.acl');
			$this->cache = app('service.cache');
			$this->log = app('service.log');
			$this->helpers = app('service.helpers');
		}
	}
