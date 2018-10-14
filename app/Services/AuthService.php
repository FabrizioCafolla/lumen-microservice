<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services;

	use Dingo\Api\Auth\Auth as DingoAuth;
	use Illuminate\Database\Eloquent\Model;
	use Tymon\JWTAuth\JWTAuth;
	use ResponseService;

	class AuthService
	{

		/**
		 * @var JWTAuth
		 */
		public $jwt;
		/**
		 * @var DingoAuth
		 */
		private $dingo;

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

		/**
		 * Get User object without check token
		 * If user don't exist response not found error
		 *
		 * @return mixed
		 */
		public function user()
		{
			$user = $this->dingo->getUser();

			if (!$user)
				return ResponseService::error("errorNotFound", "User not found");

			return ResponseService::success(compact('user'));
		}

		/**
		 * Return User object if token is valid
		 * else return error response
		 *
		 * @return mixed
		 */
		public function getUser()
		{
			$this->tryAuthenticatedUser();
			return $this->user();
		}

		/**
		 * Verification of the jwt token with specific response
		 *
		 * @return mixed
		 */
		public function tryAuthenticatedUser()
		{
			try {
				if (!$user = $this->jwt->parseToken()->authenticate())
					return ResponseService::error('errorNotFound');
			} catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
				return ResponseService::error('errorNotFound', 'The token has been blacklisted');
			} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
				return ResponseService::error('errorBadRequest', 'Token expired');
			} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
				return ResponseService::error('errorBadRequest', 'Token invalid');
			} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
				return ResponseService::error('errorNotFound', 'Token absent');
			}
			return ResponseService::success("Token is valid");
		}

		/**
		 * Set the user logged in or registered in the app so as to make the recovery of the user without much easier using the user() function
		 *
		 * @param Model $user
		 * @return mixed
		 */
		public function setUser($user)
		{
			return $this->dingo->setUser($user);
		}

		/**
		 * Check token and invalidate it
		 * Response with message
		 *
		 * @param bool $force
		 * @return mixed
		 * @throws \Tymon\JWTAuth\Exceptions\JWTException
		 */
		public function invalidate($force = false)
		{
			$this->tryAuthenticatedUser();
			$this->jwt->parseToken()->invalidate($force);
			return ResponseService::success('The token has been invalidated');
		}

		/**
		 * Refresh token and invalidate old token
		 *
		 * @param bool $force
		 * @return mixed
		 * @throws \Tymon\JWTAuth\Exceptions\JWTException
		 */
		public function refresh($force = false, $resetClaims = false)
		{
			$token = $this->jwt->parseToken()->refresh($force, $resetClaims);
			return ResponseService::success(compact('token'));
		}
	}