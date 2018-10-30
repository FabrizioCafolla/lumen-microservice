<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/10/18
	 * Time: 18.25
	 */

	namespace App\Helpers\Policies;


	abstract class AbstractPolicy
	{
		/**
		 * Check id user with id in request url
		 *
		 * @param int $userId
		 * @param string $id
		 * @return bool
		 */
		protected function checkId(int $userId, string $id) :bool
		{
			return strval($userId) === $id;
		}
	}