<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 14.48
	 */
	namespace App\Api\v1;

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
				$this->auth->utility()->setUser($this->auth->jwt->user());
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

			$assign = ACLService::assign($user, ['user'], ['read write publish']);
			if ($assign->status() == "200") {
				$this->auth->utility()->setUser($user);
				return $this->response->success(compact('user', 'token'));
			} else
				return $assign;
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
				if (!$user = $this->auth->jwt->parseToken()->authenticate())
					return $this->response->error('errorNotFound');
			} catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
				return $this->response->error('Token expired');
			} catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
				return $this->response->error('errorBadRequest', 'Token invalid');
			} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
				return $this->response->error('errorNotFound', 'Token absent');
			}
			return $this->response->success($this->auth->utility()->user());
		}
	}