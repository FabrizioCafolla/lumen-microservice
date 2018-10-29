<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/10/18
	 * Time: 14.17
	 */

	namespace App\Http\GraphQL\Type\Contracts;

	use GraphQL\Type\Definition\Type;
	use Folklore\GraphQL\Support\Type as GraphQLType;

	class TimestampType extends GraphQLType
	{
		protected $attributes = [
			'name' => 'Timestamp',
			'description' => 'Standard to get timestamp of model'
		];

		public function fields()
		{
			return [
				'created_at' => [
					'type' => Type::string(),
					'description' => 'Data of creation',
					'resolve' => function ($root) {
						return $this->timestampProcessor($root->created_at);
					}
				],
				'updated_at' => [
					'type' => Type::string(),
					'description' => 'Data of update',
					'resolve' => function ($root) {
						return $this->timestampProcessor($root->updated_at);
					}
				]
			];
		}

		/**
		 * Method to processes timestamp with Carbon method
		 * Return null if $time is null/false
		 * else return string of data
		 *
		 * @param $time
		 * @param string $toMethod (Carbon method toDateTimeString, toDateString etc..)
	     * @return string|null
		 */
		private function timestampProcessor($time, string $toMethod = 'toDateTimeString'){
			return $time?$time->{$toMethod}():null;
		}
	}