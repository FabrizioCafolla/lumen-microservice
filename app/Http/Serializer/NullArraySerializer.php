<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 16/10/18
	 * Time: 16.07
	 */

	namespace App\Http\Serializer;

	use League\Fractal\Serializer\ArraySerializer;

	class NullArraySerializer extends ArraySerializer
	{
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
			return $data;
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
			return $data;
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