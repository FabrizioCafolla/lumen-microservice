<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/10/18
	 * Time: 22.18
	 */

	namespace App\Api\GraphQL\v1\Type;

	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;

	class UserType extends GraphQLType {

		protected $attributes = [
			'name' => 'User',
			'description' => 'A user'
		];

		public function fields()
		{
			return [
				'id' => [
					'type' => Type::nonNull(Type::string()),
					'description' => 'The id of the user'
				],
				'email' => [
					'type' => Type::string(),
					'description' => 'The email of user'
				],
				'name' => [
					'type' => Type::string(),
					'description' => 'The email of user'
				]
			];
		}
	}