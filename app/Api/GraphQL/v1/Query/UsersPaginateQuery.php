<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.20
	 */

	namespace App\Api\GraphQL\v1\Query;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Query;
	use App\Repositories\UserRepository as User;

	class UsersPaginateQuery extends Query
	{

		public $user;

		protected $attributes = [
			'name' => 'usersPaginate'
		];

		public function __construct($attributes = [], User $model)
		{
			parent::__construct($attributes);
			$this->user = $model;
		}

		public function type()
		{
			return Type::listOf(GraphQL::type('UserPaginate'));
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
			$perPage = array_get($args, 'perPage', 15);
			$page = array_get($args, 'page', 1);

			return $this->user->model->paginate($perPage, ['*'], 'page', $page);
		}

	}