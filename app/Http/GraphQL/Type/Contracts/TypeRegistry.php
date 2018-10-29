<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 29/10/18
	 * Time: 19.11
	 */

	namespace App\Http\GraphQL\Type\Contracts;

	use GraphQL\Type\Definition\Type;
	use GraphQL;
	use Illuminate\Pagination\LengthAwarePaginator;

	/**
	 * Class TypeRegistry
	 * Alias TypeRegistry
	 *
	 * @package App\Http\GraphQL\Type\Contracts
	 */
	class TypeRegistry
	{
		/**
		 * Method to call TimestampType in other graphQL type
		 * 'timestamp' => TypeRegistry::timestamp()
		 *
		 * @return array
		 */
		public static function timestamp()
		{
			return [
				'type' =>  Type::listOf(GraphQL::type('Timestamp')),
				'resolve' => function ($root) {
					return array($root);
				}
			];
		}

		/**
		 * 'meta' => TypeRegistry::paginationMeta()
		 *
		 * @return array
		 */
		public static function paginationMeta()
		{
			return [
				'type' => Type::nonNull(GraphQL::type('PaginationMeta')),
				'resolve' => function (LengthAwarePaginator $paginator) {
					return $paginator->toArray();
				},
			];
		}
	}