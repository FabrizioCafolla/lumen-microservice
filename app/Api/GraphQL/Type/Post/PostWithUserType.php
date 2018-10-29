<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Api\GraphQL\Type\Post;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;
	use App\Repositories\UserRepository as User;

	class PostWithUserType extends GraphQLType
	{

		protected $attributes = [
			'name' => 'PostWithUser',
			'description' => 'Post with user'
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
				'user' => [
					'type' =>  Type::listOf(GraphQL::type('User')),
					'description' => 'The user of post',
					'resolve' => function ($root) {
						return array($root->user);
					},
				]
			];
		}
	}