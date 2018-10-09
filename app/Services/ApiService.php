<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use ResponseService;
	use Illuminate\Support\Collection;

	class ApiService
	{
		/**
		 * You can also use the Helpers service on controllers with this command $this->api->helpers
		 *
		 * @var HelpersService
		 */
		public $helpers;

		/**
		 * Array that contains any relationships that the transformer must retrieve to add then add to the response
		 * @var array
		 */
		private $availableIncludes = [];

		/**
		 * ApiService constructor.
		 */
		public function __construct()
		{
			$this->helpers = app('HelpersService');
		}

		/**
		 * Method to use the Transformers, it receives in input the type of transformer ("collection" "item" or "paginator"), the data and the additional parameters, including an array to retrieve data related to those required. This function returns a collaction or a json error response.
		 *
		 * @param $type
		 * @param $data
		 * @param array $paramatres
		 * @param \Closure $function
		 * @param array $availableData => string content for add element to collect
		 * @return Collection
		 */
		public function transform($type = "collection", $data, $model, array $availableData = [], array $paramatres = [], \Closure $function = NULL)
		{
			$this->availableIncludes = $availableData;

			if ($this->availableIncludes)
				$response = $this->helpers->response->{$type}($data, new $model, $paramatres, function ($resource, $fractal) {
					$fractal->parseIncludes($this->availableIncludes);
				});
			else
				$response = $this->helpers->response->{$type}($data, new $model, $paramatres, $function);

			if (!$response->isEmpty())
				return collect($response)->get("original");
			else
				return ResponseService::error("notFound");
		}
	}