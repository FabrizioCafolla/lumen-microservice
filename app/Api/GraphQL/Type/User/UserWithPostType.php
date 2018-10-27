<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Api\GraphQL\Type\User;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;

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
					'description' => 'The id of the user'
				],
				'email' => [
					'type' => Type::string(),
					'description' => 'The email of user'
				],
				'name' => [
					'type' => Type::string(),
					'description' => 'The email of user'
				],
				'post' => [
					'type' =>  Type::listOf(GraphQL::type('Post')),
					'description' => 'The posts of user'
				]
			];
		}
	}