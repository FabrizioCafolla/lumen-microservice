<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 16/10/18
	 * Time: 16.07
	 */

	namespace App\Http\Serializer;

	use League\Fractal\Serializer\ArraySerializer;

	class KeyArraySerializer extends ArraySerializer
	{
		private $key;

		public function __construct($key = null)
		{
			$this->key = $key;
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
			if($resourceKey === -1 || (!$resourceKey && !$this->key))
				return $data;

			if ($resourceKey)
				return array_add([], $resourceKey, $data);

			if ($this->key)
				return array_add([], $this->key, $data);
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
			if($resourceKey === -1 || (!$resourceKey && !$this->key))
				return $data;

			if ($resourceKey)
				return array_add([], $resourceKey, $data);

			if ($this->key)
				return array_add([], $this->key, $data);
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