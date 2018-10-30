<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/10/18
	 * Time: 18.25
	 */

	namespace App\Helpers\Policies;


	use App\Models\User;
	use Illuminate\Http\Request;

	class UserPolicy
	{
		/**
		 * Determine if the given user can be updated by the user.
		 *
		 * @param User $user
		 * @param Request $request
		 * @return bool
		 */
		public function update(User $user, Request $request)
		{
			return $this->checkId($user->id, $request->id);
		}

		/**
		 * Determine if the given user can be deleted by the user.
		 *
		 * @param User $user
		 * @param Request $request
		 * @return bool
		 */
		public function delete(User $user, Request $request)
		{
			return $this->checkId($user->id, $request->id);
		}

		/**
		 * Check id user with id in request url
		 *
		 * @param int $userId
		 * @param string $requestId
		 * @return bool
		 */
		private function checkId(int $userId, string $requestId) :bool
		{
			return strval($userId) === $requestId;
		}
	}