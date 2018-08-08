<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services\Auth\Contracts;

	use App\Repositories\UserRepository as User;
	use Illuminate\Http\Request;
	use JWTAuth;
	use Tymon\JWTAuth\Exceptions\JWTException;

	class AuthServiceAbstract
	{
		/** User Repository
		 *
		 * @var User
		 */
		protected $auth;

		/** Service for response
		 *
		 * @var ResponseService
		 */
		protected $response;

		/**
		 * AuthService constructor.
		 * @param User $user
		 */
		public function __construct($auth)
		{
			$this->response = app('ResponseService');

			$this->auth = app($auth);
		}

		/** Register method
		 * @param Request $request
		 * @return mixed (user + token) or (errors)
		 */
		public function register(Request $request)
		{
			$validator = $this->auth->validateRequest($request->all(), "store");

			if ($validator->status() == "200") {
				$user = $this->auth->create($request->all());

				$token = JWTAuth::fromUser($user);
				if (!$token)
					return $this->response->error("internal");

				return $this->response->custom(compact('user','token'));
			}
			return $this->response->custom($validator->content());
		}

		/**
		 * @param Request $request
		 * @return mixed (token) or (errors)
		 */
		public function authenticate(Request $request)
		{
			$credentials = $request->only('email', 'password');
			try {
				$token = JWTAuth::attempt($credentials);
				if (!$token) {
					return $this->response->error("unauthorized", 'Invalid credentials');
				}
			} catch (JWTException $e) {
				return $this->response->error("error", 'Could not create token.');
			}
			return $this->response->custom(compact('token'));
		}

		public function getAuthenticatedUser()
		{
			try {

				if (! $user = JWTAuth::parseToken()->authenticate()) {
					return $this->response->custom('notFound');
				}

			} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

				return $this->response->custom(['token expired']);

			} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

				return $this->response->custom(['token invalid']);

			} catch (JWTException $e) {

				return $this->response->custom(['token absent']);

			}

			return $this->response->custom(compact('user'));
		}
	}