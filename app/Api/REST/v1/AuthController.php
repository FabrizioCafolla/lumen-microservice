<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 14.48
	 */

	namespace App\Api\REST\v1;

	use App\Repositories\UserRepository;
	use ACLService;
	use Illuminate\Http\Request;


	class AuthController extends ApiBaseController
	{
		/** User Repository
		 *
		 * @var User
		 */
		private $model;


		/**
		 * @Var auth instance of Auth service
		 */
		public function __construct()
		{
			parent::__construct();
			$this->model = app(UserRepository::class);
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
				$token = $this->auth->jwt->attempt($credentials);
				if (!$token)
					return $this->response->error("errorUnauthorized", 'Invalid credentials');
			} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
				return $this->response->error("errorInternal", 'Could not create token.');
			}
			return $this->response->success(compact('token'));
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

			$validator = $this->model->validateRequest($request->all(), "store");

			if ($validator->status() != "200")
				return $validator;

			$user = $this->model->create($request->all());

			$token = $this->auth->jwt->fromUser($user);
			if (!$token)
				return $this->response->error("errorInternal");

			return $this->response->success(compact('user', 'token'));
		}

		/**
		 * Method for check user authenticated.
		 * Return user playload or Exception
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function getAuthenticatedUser()
		{
			return $this->auth->getUser();
		}

		/**
		 * @return mixed
		 */
		public function invalidate()
		{
			return $this->auth->invalidate(true);
		}

		/**
		 * @return mixed
		 */
		public function refresh()
		{
			return $this->auth->refresh(true);
		}
	}