<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Laravel\Lumen\Application;

	class ApiService
	{
		private $availableIncludes = [];

		private $response;

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
			} else {
				if ($this->availableIncludes)
					$response = $this->helpers->response->item($data, new $model, $paramatres, function ($resource, $fractal) {
						$fractal->parseIncludes($this->availableIncludes);
					});
				else
					$response = $this->helpers->response->item($data, new $model, $paramatres, $function);
			}

			if (!$response->isEmpty())
				return collect($response)->get("original");
			else
				return $this->response->error("notFound");
		}
	}