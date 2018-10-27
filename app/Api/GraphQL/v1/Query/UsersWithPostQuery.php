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

	class UsersWithPostQuery extends Query
	{

		public $user;
		protected $attributes = [
			'name' => 'usersWithPost'
		];

		public function __construct($attributes = [], User $model)
		{
			parent::__construct($attributes);
			$this->user = $model;
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
				return array($this->user->find($args['id']));
			} else if (isset($args['email'])) {
				return array($this->user->findBy('email', $args['email']));
			} else {
				return $this->user->all();
			}
		}

	}