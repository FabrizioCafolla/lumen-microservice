<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Api\GraphQL\v1\Type;

	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;

	class PostType extends GraphQLType {

		protected $attributes = [
			'name' => 'Post',
			'description' => 'Post of users'
		];

		public function fields()
		{
			return [
				'id' => [
					'type' => Type::nonNull(Type::string()),
					'description' => 'The id of the post'
				],
				'title' => [
					'type' => Type::string(),
					'description' => 'The title of post'
				],
				'description' => [
					'type' => Type::string(),
					'description' => 'The description of post'
				],
				'status' => [
					'type' => Type::string(),
					'description' => 'Status of post'
				]
			];
		}
	}