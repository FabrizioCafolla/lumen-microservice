<?php

	namespace App\Api\v1;

	use Laravel\Lumen\Routing\Controller as BaseController;

	class ApiBaseController extends BaseController
	{
		public $api;

		public function __construct()
		{
			$this->api = app('ApiService');
		}
	}
