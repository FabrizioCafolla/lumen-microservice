<?php

	namespace App\Api\v1;

	use Dingo\Api\Http\Request;
	use Laravel\Lumen\Routing\Controller as BaseController;


	class ApiBaseController extends BaseController
	{
		/*
		 * @Var Api service
		 */
		public $api;

		/*
		 * @Var Response service
		 */
		public $response;

		/*
		 * @Var Request
		 */
		public $request;

		public function __construct()
		{
			$this->api = app('ApiService');
			$this->response = app('ResponseService');

			$this->request = new Request;
			$this->request = $this->request->json();
		}
	}
