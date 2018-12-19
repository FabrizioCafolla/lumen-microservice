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
	use App\Repositories\UserRepository as User;

	class UsersWithPostQuery extends Query
	{

		public $model;
		protected $attributes = [
			'name' => 'usersWithPost',
			'uri' => 'query=query{usersWithPost{id,name,email,post{},timestamp{}}}'
		];

		public function __construct($attributes = [], User $model)
		{
			parent::__construct($attributes);
			$this->model = $model;
		}

		public function type()
		{
			return Type::listOf(GraphQL::type('UserWithPost'));
		}

		public function args()
		{
			return [
				'id' => ['name' => 'id', 'type' => Type::string()],
				'email' => ['name' => 'email', 'type' => Type::string()],
				'name' => ['name' => 'name', 'type' => Type::string()],
			];
		}

		public function resolve($root, $args)
		{
			if (isset($args['id'])) {
				return array($this->model->find($args['id']));
			} else if (isset($args['email'])) {
				return array($this->model->findBy('email', $args['email']));
			} else {
				return $this->model->all();
			}
		}

	}