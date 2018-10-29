<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.20
	 */

	namespace App\Api\GraphQL\v1\Query;

	use ApiService;
	use App\Repositories\PostRepository as Post;
	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Query;

	class PostsPaginationQuery extends Query
	{

		public $model;

		protected $attributes = [
			'name' => 'usersPaginate',
			'uri' => 'query=query{postsPagination(perPage:15,page:1){post{id},meta{total}}}'
		];

		public function __construct($attributes = [], Post $model)
		{
			parent::__construct($attributes);
			$this->model = $model;
		}

		public function type()
		{
			return GraphQL::pagination(GraphQL::type('Post'));
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

			$posts = $this->model->paginate($perPage, ['*']); //@TODO fix url page

			return $posts;
		}

	}