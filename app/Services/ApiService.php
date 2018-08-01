<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Dingo\Api\Routing\Helpers;
	use Laravel\Lumen\Application;

	class ApiService
	{
		use Helpers;

		public $app;

		protected $availableIncludes = [];

		public function __construct(Application $app)
		{
			$this->app = $app;
		}

		public function custom($content, $status = 200, array $headers = [], $options = 0){
			if(empty($content))
				$this->custom(['status' => null, "message" => null]);

			return response()->json($content, $status, $headers, $options);
		}

		public function success($content = "")
		{
			return $this->app->version();
		}

		public function error($type = null, $content = "")
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
					return $this->custom(['status' => "400", 'message' => $content ? $content : "generic error"]);
					break;
			}
		}

		/**
		 * @param $tyep => "collection" or "item"
		 * @param $data => data to transform
		 * @param array $paramatres
		 * @param function $function
		 * @param array $availableData => string content for add element to collect
		 * @return collect
		 */
		public function transform($type, $data, $model, array $paramatres = [], \Closure $function = NULL, array $availableData = [])
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
				return collect($response)->get("original");
			else
				return $this->error("notFound");
		}
	}