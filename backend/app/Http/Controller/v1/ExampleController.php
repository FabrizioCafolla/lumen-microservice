<?php

	namespace App\Http\Controller\v1;

	use App\Http\Controller\RestController;

	class ExampleController extends RestController
	{
		public function test () {
		    return $this->response->success()
				->withMessage('Microservice Lumen work')
				->withState();
        }
	}
