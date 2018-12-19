<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Http\GraphQL\Type\Post;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;
	use App\Http\GraphQL\Type\MyTypeRegistry;

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
				],
				'title' => [
					'type' => Type::string(),
				],
				'description' => [
					'type' => Type::string(),
				],
				'user' => [
					'type' =>  Type::listOf(GraphQL::type('User')),
					'resolve' => function ($root) {
						return array($root->user);
					},
				],
				'timestamp' => MyTypeRegistry::timestamp()
			];
		}
	}