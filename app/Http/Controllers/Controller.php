<?php

	namespace App\Http\Controllers;

	use Laravel\Lumen\Routing\Controller as BaseController;

	class Controller extends BaseController
	{
		/*
		 * @Var Response service
		 */
		public $response;

		/*
		 * @Var Helpers service
		 */
		public $helpers;



		public function __construct()
		{
			$this->response = app('ResponseService');
			$this->helpers = app('HelpersService');
		}
	}
