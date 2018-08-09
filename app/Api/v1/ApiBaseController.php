<?php

	namespace App\Api\v1;

	use Dingo\Api\Http\Request;
	use Laravel\Lumen\Routing\Controller as BaseController;


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

		public function __construct()
		{
			$this->api = app('ApiService');
			$this->response = app('ResponseService');
			$this->acl = app('ACLService');
			$this->helpers = $this->api->helpers;
			$this->request = new Request;
		}
	}
