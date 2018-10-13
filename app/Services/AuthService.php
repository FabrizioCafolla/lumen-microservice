<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services;

	use App\Repositories\UserRepository as User;
	use Dingo\Api\Auth\Auth as DingoAuth;
	use Illuminate\Http\Request;
	use Tymon\JWTAuth\JWTAuth;
	use ACLService;
	use Tymon\JWTAuth\Exceptions\JWTException;

	class AuthService
	{
		/**
		 * @var DingoAuth
		 */
		private $dingo;

		/**
		 * @var JWTAuth
		 */
		public $jwt;

		/**
		 * AuthService constructor.
		 *
		 * @param User $user
		 */
		public function __construct()
		{
			$this->dingo = app(DingoAuth::class);
			$this->jwt = app(JWTAuth::class);
		}

		public function utility() {
			return $this->dingo;
		}
	}