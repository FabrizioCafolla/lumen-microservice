<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Http\GraphQL\Type\Post;

	use TypeRegistry;
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
				],
				'title' => [
					'type' => Type::string(),
				],
				'description' => [
					'type' => Type::string(),
				],
				'status' => [
					'type' => Type::string(),
				],
				'timestamp' => TypeRegistry::timestamp()
			];
		}
	}