<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/10/18
	 * Time: 14.17
	 */

	namespace App\Api\GraphQL\Type\Contracts;

	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;

	class PaginationMetaType extends GraphQLType
	{
		protected $attributes = [
			'name' => 'PaginationCursor'
		];

		public function fields()
		{
			return [
				'total' => [
					'type' => Type::int(),
					'description' => 'The total number of items'
				],
				'per_page' => [
					'type' => Type::int(),
					'description' => 'The count on a page'
				],
				'current_page' => [
					'type' => Type::int(),
					'description' => 'The current page'
				],
				'last_page' => [
					'type' => Type::int(),
					'description' => 'The last page'
				],
				'first_page_url' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'from' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'last_page_url' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'next_page_url' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'path' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'prev_page_url' => [
					'type' => Type::string(),
					'description' => 'The last page'
				],
				'to' => [
					'type' => Type::string(),
					'description' => 'The last page'
				]
			];
		}
	}