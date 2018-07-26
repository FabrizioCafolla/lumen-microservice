<?php

namespace App\Api\v1;

use Dingo\Api\Routing\Helpers;
use Laravel\Lumen\Routing\Controller as BaseController;

class ApiBaseController extends BaseController
{
    use Helpers;

	protected function success($message = null)
	{
		return $this->response->array(['success' => true, 'message' => $message]);
	}

	protected function error($type = null, $message = null)
	{
		switch ($type){
			case "error":
				// A generic error with custom message and status code.
				return $this->response->error($message ? $message : 'This is an error.', 404);
				break;

			case "notFound":
				// A not found error with an optional message as the first parameter.
				return $this->response->errorNotFound();
				break;

			case "badRequest":
				// A bad request error with an optional message as the first parameter.
				return $this->response->errorBadRequest();
				break;

			case "forbidden":
				// A forbidden error with an optional message as the first parameter.
				return $this->response->errorForbidden();
				break;

			case "internal":
				// An internal error with an optional message as the first parameter.
				return $this->response->errorInternal();
				break;

			case "unauthorized":
				// An unauthorized error with an optional message as the first parameter.
				return $this->response->errorUnauthorized();
				break;

			default:
				return $this->response->array(['success' => false, 'message' => $message]);
				break;
		}
	}
}
