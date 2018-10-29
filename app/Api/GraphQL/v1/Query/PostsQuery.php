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

	class PostsQuery extends Query
	{

		public $post;
		protected $attributes = [
			'name' => 'users'
		];

		public function __construct($attributes = [], Post $model)
		{
			parent::__construct($attributes);
			$this->post = $model;
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
				return array($this->post->find($args['id']));
			} else if (isset($args['title'])) {
				return array($this->post->findBy('title', $args['title']));
			} else {
				return $this->post->all();
			}
		}

	}