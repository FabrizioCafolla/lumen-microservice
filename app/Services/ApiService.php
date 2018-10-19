<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use ResponseService;
	use HelpersService;
	use League\Fractal\Pagination\IlluminatePaginatorAdapter;
	use League\Fractal\Resource\Item;
	use League\Fractal\Resource\Collection;
	use League\Fractal\Manager;

	class ApiService
	{
		private $fractal;

		public function __construct()
		{
			$this->fractal = app(Manager::class);
		}

		/**
		 * Create collection with data Transformer
		 *
		 * @param $data (instance of Collection)
		 * @param $transformer (class of Transformer)
		 * @param null $availableData (array or string to add data to collection
		 * @param null $serializer (class of Serialize)
		 * @return mixed
		 */
		public function collection($data, $transformer, $availableData = null, $serializer = null)
		{
			$resource = new Collection($data, $transformer);
			return $this->transform($resource, $serializer, $availableData);
		}

		/**
		 * @param $data (instance of Paginate)
		 * @param $transformer (class of Transformer)
		 * @param null $availableData (array or string to add data to collection
		 * @param null $serializer (class of Serialize)
		 * @return mixed
		 */
		public function paginate($data, $transformer, $availableData = null, $serializer = null)
		{
			$resource = new Collection($data->getCollection(), $transformer);
			$resource->setPaginator(new IlluminatePaginatorAdapter($data));
			return $this->transform($resource, $serializer, $availableData);
		}

		/**
		 * @param $data
		 * @param $transformer (class of Transformer)
		 * @param null $availableData (array or string to add data to collection
		 * @param null $serializer (class of Serialize)
		 * @return mixed
		 */
		public function item($data, $transformer, $availableData = null, $serializer = null)
		{
			$resource = new Item($data, $transformer);
			return $this->transform($resource, $serializer, $availableData);
		}

		/**
		 * @param $serializer
		 * @return $this
		 */
		public function serializer($serializer){
			$this->fractal->setSerializer($serializer);
			return $this;
		}

		/**
		 * @param $includes
		 * @return $this
		 */
		public function includes($includes){
			$this->fractal->parseIncludes($includes);
			return $this;
		}

		/**
		 * @param $excludes
		 * @return $this
		 */
		public function excludes($excludes){
			$this->fractal->parseExcludes($excludes);
			return $this;
		}

		/**
		 * @param $limit
		 * @return $this
		 */
		public function recursionLimit($limit){
			$this->fractal->setRecursionLimit($limit);
			return $this;
		}

		/**
		 * @param $data
		 * @param $serializer
		 * @param $availableData
		 * @return mixed
		 */
		private function transform($data, $serializer, $availableData){
			if($serializer)
				$this->serializer($serializer);
			if($availableData)
				$this->includes($availableData);
			return $this->fractal->createData($data)->toArray();
		}
	}