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

	class DataType extends GraphQLType
	{
		protected $attributes = [
			'name' => 'PaginationCursor'
		];

		public function fields()
		{
			return [
				'created_at' => [
					'type' => Type::string(),
					'description' => 'Data of creation',
					'resolve' => function ($root) {
						return $this->timestampProcessor($root->created_at);
					}
				],
				'updated_at' => [
					'type' => Type::string(),
					'description' => 'Data of update',
					'resolve' => function ($root) {
						return $this->timestampProcessor($root->updated_at);
					}
				]
			];
		}

		public function timestampProcessor($time, string $toMethod = 'toDateTimeString'){
			return $time?$time->{$toMethod}():null;
		}
	}