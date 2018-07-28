<?php

	namespace App\Api\v1;

	use Dingo\Api\Routing\Helpers;
	use \Dingo\Api\Http\Response as DingoResponse;
	use Laravel\Lumen\Routing\Controller as BaseController;

	class ApiBaseController extends BaseController
	{
		use Helpers;

		protected $availableIncludes = [];

		protected function custom($response = [])
		{
			return $this->response->array($response);
		}

		protected function success($content = null)
		{
			return $this->response->array(['status' => "200", 'message' => $content]);
		}

		protected function transform($type, $data, $model, array $paramatres = [], \Closure $function = NULL, array $availableData = [])
		{
			$this->availableIncludes = $availableData;

			if ($type == "collection") {
				if ($this->availableIncludes)
					$response = $this->response->collection($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->response->collection($data, new $model, $paramatres, $function);
			} else {
				if ($this->availableIncludes)
					$response = $this->response->item($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->response->item($data, new $model, $paramatres, $function);
			}

			if (!$response->isEmpty())
				return $response;
			else
				return $this->error("notFound");
		}

		protected function error($type = null, $content = null)
		{
			switch ($type) {
				case "error":
					// A generic error with custom message and status code.
					return $this->response->error($content ? $content : 'This is an error.', 404);
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
					return $this->response->array(['success' => false, 'message' => $content]);
					break;
			}
		}
	}
