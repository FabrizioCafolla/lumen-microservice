<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 29/10/18
	 * Time: 19.11
	 */

	namespace App\Api\GraphQL\Type;

	use GraphQL\Type\Definition\Type;
	use GraphQL;

	class TypeRegistry
	{
		/**
		 * Method to call DataType in other graphQL type
		 * 'timestamp' => TypeRegistry::timestamp()
		 *
		 * @return array
		 */
		public static function timestamp()
		{
			return [
				'type' =>  Type::listOf(GraphQL::type('Data')),
				'resolve' => function ($root) {
					return array($root);
				}
			];
		}
	}