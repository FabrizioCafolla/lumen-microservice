<?php

	namespace App\Api\v1;

	use Laravel\Lumen\Routing\Controller as BaseController;
	use App\Services\ApiService;

	class ApiBaseController extends BaseController
	{
		public $api;

		public function __construct(ApiService $apiService)
		{
			$this->api = $apiService;
		}
	}
