<?php

	namespace App\Api\v1;

	use Dingo\Api\Http\Request;
	use Laravel\Lumen\Routing\Controller as BaseController;
	use App\Repositories\CacheRepository;


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
		 * @var HelpersService
		 */
		public $helpers;

		/**
		 * @var ACLService
		 */
		public $acl;

		/**
		 * @var Request
		 */
		public $request;

		/**
		 * @var Cache
		 */
		public $cache;

		public function __construct()
		{
			$this->api = app('ApiService');
			$this->response = app('ResponseService');
			$this->acl = app('ACLService');
			$this->cache = app('CacheService');
			$this->helpers = $this->api->helpers;
			$this->request = new Request;
		}
	}
