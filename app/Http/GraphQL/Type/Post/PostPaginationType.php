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
	use TypeRegistry;

	class PostPaginationType extends GraphQLType
	{

		protected $attributes = [
			'name' => 'PostPagination',
			'description' => 'Posts with paginate',
		];

		public function fields()
		{
			return [
				'post' => [
					'type' => Type::listOf(GraphQL::type('Post')),
					'resolve' => function ($root) {
						return $root;
					}
				],
				'meta' => TypeRegistry::paginationMeta()
			];
		}
	}