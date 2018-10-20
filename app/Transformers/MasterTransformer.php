<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/07/18
	 * Time: 12.52
	 */

	namespace App\Transformers;

	use League\Fractal\TransformerAbstract;

	class MasterTransformer extends TransformerAbstract
	{
		/**
		 * @param mixed $data
		 * @param callable|TransformerAbstract $transformer
		 * @param int $resourceKey (default -1 because it check in KeyArraySerializer)
		 * @return \League\Fractal\Resource\Collection
		 */
		public function collection($data, $transformer, $resourceKey = -1)
		{
			return parent::collection($data, $transformer, $resourceKey);
		}

		public function item($data, $transformer, $resourceKey = -1)
		{
			return parent::item($data, $transformer, $resourceKey);
		}
	}