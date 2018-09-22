<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services;

	use App\Repositories\UserRepository as User;
	use Illuminate\Http\Request;
	use JWTAuth;
	use Tymon\JWTAuth\Exceptions\JWTException;

	class AuthService
	{

		/** User Repository
		 *
		 * @var User
		 */
		private $user;

		/** Service for response
		 *
		 * @var ResponseService
		 */
		private $acl;

		/** Service for response
		 *
		 * @var ResponseService
		 */
		private $response;

		/**
		 * AuthService constructor.
		 * @param User $user
		 */
		public function __construct()
		{
			$this->response = app('ResponseService');
			$this->acl = app('ACLService');
			$this->user = app(User::class);
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

		/**
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function getAuthenticatedUser()
		{
			try {
				if (!$user = JWTAuth::parseToken()->userenticate())
					return $this->response->custom('notFound');
			} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
				return $this->response->custom(['token expired']);
			} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
				return $this->response->custom(['token invalid']);
			} catch (JWTException $e) {
				return $this->response->custom(['token absent']);
			}
			return $this->response->custom(compact('user'));
		}

		/** Register method
		 * @param Request $request
		 * @return mixed (user + token) or (errors)
		 */
		public function register(Request $request)
		{
			$validator = $this->user->validateRequest($request->all(), "store");

			if ($validator->status() != "200")
				return $this->response->error("badRequest", $validator->content(), 400);

			$user = $this->user->create($request->all());
			$token = JWTAuth::fromUser($user);
			if (!$token)
				return $this->response->error("internal");

			$assign = $this->acl->assign($user, ['user'], ['read write publish']);
			if($assign->status() == "200")
				return $this->response->custom(compact('user', 'token'));
			else
				return $assign;
		}

	}