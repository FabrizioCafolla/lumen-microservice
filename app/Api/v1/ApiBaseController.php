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

		/*
		* @Var Helpers service
		*/
		public $helpers;

		public function __construct()
		{
			$this->api = app('ApiService');
			$this->response = app('ResponseService');

			$this->helpers = $this->api->helpers;

			$this->request = new Request;
			$this->request = $this->request->json();
		}
	}
