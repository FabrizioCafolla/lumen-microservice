<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	class ApiService
	{
		/**
		 * @var array
		 */
		private $availableIncludes = [];

		/** Response for internal controller
		 * @var ResponseService
		 */
		private $response;

		/**
		 * @var HelpersService
		 */
		public $helpers;

		public function __construct()
		{
			$this->helpers = app('HelpersService');
			$this->response = app('ResponseService');
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
					$response = $this->helpers->response->collection($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->helpers->response->collection($data, new $model, $paramatres, $function);
			}
			if ($type == "item") {
				if ($this->availableIncludes)
					$response = $this->helpers->response->item($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->helpers->response->item($data, new $model, $paramatres, $function);
			}

			if ($type == "paginator") {
				if ($this->availableIncludes)
					$response = $this->helpers->response->paginator($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->helpers->response->paginator($data, new $model, $paramatres, $function);
			}

			// Return transformer in collection or error not found data
			if (!$response->isEmpty())
				return collect($response)->get("original");
			else
				return $this->response->error("notFound");
		}
	}