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

		public function transform()
		{
			return [];
		}

		// example file:
		// https://gist.github.com/FabrizioCafolla/b132d6eafbb5c851b7610f8cf927bdf4#file-posttransformer-php
		// https://gist.github.com/FabrizioCafolla/b132d6eafbb5c851b7610f8cf927bdf4#file-usertransformer-php
	}