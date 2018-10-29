<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 16/10/18
	 * Time: 16.07
	 */

	namespace App\Helpers\Serializer;

	use League\Fractal\Serializer\ArraySerializer;

	/**
	 * Class KeyArraySerializer
	 * @package App\Helpers\Serializer
	 */
	class KeyArraySerializer extends ArraySerializer
	{
		/**
		 *
		 * @var null
		 */
		private $arrayKey;

		public function __construct(string $key = '')
		{
			$this->arrayKey = $key;
		}

		/**
		 * Serialize a collection.
		 *
		 * @param string $resourceKey
		 * @param array  $data
		 *
		 * @return array
		 */
		public function collection($resourceKey, array $data)
		{
			//if resourceKey are equal -1, default value to exclude the arrayKey variable from the array that will be included by the includesName() methods of the Transformer
			//or resourceKey and arrayKey are null
			if($resourceKey === -1 || (!$resourceKey && !$this->arrayKey))
				return $data;

			//if value of resorceKey is different that null or -1
			if ($resourceKey)
				return array_add([], $resourceKey, $data);

			//if value of arrayKey is differet that null
			if ($this->arrayKey)
				return array_add([], $this->arrayKey, $data);
		}

		/**
		 * Serialize an item.
		 *
		 * @param string $resourceKey
		 * @param array  $data
		 *
		 * @return array
		 */
		public function item($resourceKey, array $data)
		{
			//if resourceKey are equal -1, default value to exclude the arrayKey variable from the array that will be included by the includesName() methods of the Transformer
			//or resourceKey and arrayKey are null
			if($resourceKey === -1 || (!$resourceKey && !$this->arrayKey))
				return $data;

			//if value of resourceKey is different that null or -1
			if ($resourceKey)
				return array_add([], $resourceKey, $data);

			//if value of arrayKey is different that null
			if ($this->arrayKey)
				return array_add([], $this->arrayKey, $data);
		}

		/**
		 * Serialize null resource.
		 *
		 * @return array
		 */
		public function null()
		{
			return [];
		}
	}