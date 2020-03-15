<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/07/18
	 * Time: 12.52
	 */

	namespace App\Transformers;

	use League\Fractal\TransformerAbstract;

	class ExampleTransformer extends TransformerAbstract
	{
		protected $availableIncludes = [];

		protected $defaultIncludes = [];

		public function transform() {}

		public function includeUser() {}
	}