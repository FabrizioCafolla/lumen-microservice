<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Http\GraphQL\Type\User;

	use Carbon\Carbon;
	use GraphQL;
	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;
	use TypeRegistry;

	class UserType extends GraphQLType
	{

		protected $attributes = [
			'name' => 'User',
			'description' => 'A user'
		];

		public function fields()
		{
			return [
				'id' => [
					'type' => Type::nonNull(Type::string()),
				],
				'email' => [
					'type' => Type::string(),
				],
				'name' => [
					'type' => Type::string(),
				],
				'timestamp' => TypeRegistry::timestamp()
			];
		}
	}