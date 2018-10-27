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
	use Illuminate\Pagination\LengthAwarePaginator;

	class UserPaginateType extends GraphQLType
	{

		protected $attributes = [
			'name' => 'UserPaginate',
			'description' => 'User with paginate'
		];

		public function fields()
		{
			return [
				'pageInfo' => [
					'type' => GraphQL::type('pageInfo'),
					'resolve' => function ($root, $args) {
						$paginate = new LengthAwarePaginator($root, $root->count(), 15); //@TODO fix perPage
						return $paginate->toArray();
					}
				],
				'user' => [
					'type' => Type::listOf(GraphQL::type('User')),
					'resolve' => function ($root) {
						return array($root);
					}
				]
			];
		}
	}