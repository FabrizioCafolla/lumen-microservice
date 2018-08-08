<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services\Auth;

	use App\Repositories\UserRepository as User;
	use App\Services\Auth\Contracts\AuthServiceAbstract;

	class UserAuthService extends AuthServiceAbstract

	{
		/**
		 * AuthService constructor.
		 * @param User $user
		 */
		public function __construct()
		{
			parent::__construct(User::class);
		}

	}