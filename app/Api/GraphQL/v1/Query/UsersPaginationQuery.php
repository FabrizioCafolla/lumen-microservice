<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.20
	 */

	namespace App\Api\GraphQL\v1\Query;

	use ApiService;
	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Query;
	use App\Repositories\UserRepository as User;

	class UsersPaginationQuery extends Query
	{

		public $user;

		protected $attributes = [
			'name' => 'usersPaginate',
			'uri' => 'query=query{usersPagination(perPage:15,page:1){user{id,name},meta{total}}}'
		];

		public function __construct($attributes = [], User $model)
		{
			parent::__construct($attributes);
			$this->user = $model;
		}

		public function type()
		{
			return GraphQL::pagination(GraphQL::type('User'));
		}

		public function args()
		{
			return [
				'page' => [
					'name' => 'page',
					'description' => 'The page',
					'type' => Type::int()
				],
				'perPage' => [
					'name' => 'perPage',
					'description' => 'The count',
					'type' => Type::int()
				]
			];
		}

		public function resolve($root, $args)
		{
			$page = array_get($args, 'page', 1);
			$perPage = array_get($args, 'perPage', 15);

			$users = $this->user->paginate($perPage, ['*']);

			return $users;
		}

	}