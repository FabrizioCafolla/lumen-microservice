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

		/** Service Response
		 *
		 * @var ResponseService
		 */
		private $response;

		/**
		 * AuthService constructor.
		 *
		 * @param User $user
		 */
		public function __construct()
		{
			$this->response = app('ResponseService');
			$this->user = app(User::class);
		}

		/**
		 * User authentication with JWT.
		 * Returns the token or an error response
		 *
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
			return $this->response->success(compact('token'));
		}

		/**
		 * Method for check user authenticated.
		 * Return user playload or Exception
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function getAuthenticatedUser()
		{
			try {
				if (!$user = JWTAuth::parseToken()->userenticate())
					return $this->response->error('notFound');
			} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
				return $this->response->custom('token expired', 400);
			} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
				return $this->response->custom('token invalid', 400);
			} catch (JWTException $e) {
				return $this->response->custom('token absent', 400);
			}
			return $this->response->success(compact('user'));
		}

		/**
		 * Register method.
		 * The request is validated by the user repository method, then it is created and then authenticated with JWT which creates the token.
		 * If the token is successfully created, the roles and permssi are assigned to the user.
		 * Return a reply with the user and the token
		 *
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

			$assign = ACLService::assign($user, ['user'], ['read write publish']);
			if($assign->status() == "200")
				return $this->response->success(compact('user', 'token'));
			else
				return $assign;
		}

	}