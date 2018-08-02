<?php

	namespace App\Api\v1;

	use Laravel\Lumen\Routing\Controller as BaseController;
	use Dingo\Api\Routing\Helpers;


	class ApiBaseController extends BaseController
	{
		public $api;
		public $response;

		public function __construct()
		{
			$this->api = app('ApiService');
			$this->response = app('ResponseService');
		}
	}
