<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.20
	 */

	namespace App\Http\GraphQL\v1\Query;

	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Query;
	use App\Repositories\PostRepository as Post;

	class PostsQuery extends Query
	{

		public $model;
		protected $attributes = [
			'name' => 'posts',
			'uri' => 'query=query{posts{id,title,description,timestamp{}}}}'
		];

		public function __construct($attributes = [], Post $model)
		{
			parent::__construct($attributes);
			$this->model = $model;
		}

		public function type()
		{
			return Type::listOf(GraphQL::type('Post'));
		}

		public function args()
		{
			return [
				'id' => ['name' => 'id', 'type' => Type::int()],
				'title' => ['name' => 'title', 'type' => Type::string()]
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