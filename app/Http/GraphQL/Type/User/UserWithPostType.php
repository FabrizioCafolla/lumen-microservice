<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Http\GraphQL\Type\User;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;
	use TypeRegistry;

	class UserWithPostType extends GraphQLType
	{

		protected $attributes = [
			'name' => 'UserWithPost',
			'description' => 'User with post'
		];

		public function fields()
		{
			return [
				'id' => [
					'type' => Type::nonNull(Type::string()),
				],
				'email' => [
					'type' => Type::string(),
				],
				'name' => [
					'type' => Type::string(),
				],
				'post' => [
					'type' => Type::listOf(GraphQL::type('Post')),
				],
				'timestamp' => TypeRegistry::timestamp()
			];
		}
	}