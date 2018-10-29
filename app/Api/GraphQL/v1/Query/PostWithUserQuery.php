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
	use App\Repositories\PostRepository as Post;

	class PostWithUserQuery extends Query
	{

		public $model;
		protected $attributes = [
			'name' => 'postsWithUser'
		];

		public function __construct($attributes = [], Post $model)
		{
			parent::__construct($attributes);
			$this->model = $model;
		}

		public function type()
		{
			return Type::listOf(GraphQL::type('PostWithUser'));
		}

		public function args()
		{
			return [
				'id' => ['name' => 'id', 'type' => Type::int()],
				'title' => ['name' => 'email', 'type' => Type::string()],
			];
		}

		public function resolve($root, $args)
		{
			if (isset($args['id'])) {
				return array($this->model->find($args['id']));
			} else if (isset($args['title'])) {
				return array($this->model->findBy('title', $args['title']));
			} else {
				return $this->model->all();
			}
		}

	}