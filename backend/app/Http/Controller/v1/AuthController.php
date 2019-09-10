<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 14.48
	 */

	namespace App\Http\Controller\v1;

	use App\Http\Controller\RestController;
	use App\Repositories\AuthRepository;
	use Illuminate\Http\Request;

	class AuthController extends RestController
	{
		/** User Repository
		 *
		 * @var User
		 */
		private $model;


		/**
		 * @Var auth instance of Auth service
		 */
		public function __construct() {
			parent::__construct();
			$this->model = app(AuthRepository::class);
		}

		/**
		 * User authentication with JWT.
		 * Returns the token or an error response
		 *
		 * @param Request $request
		 *
		 * @Request:
			"data": {
				"type": "user",
				"attributes": {
					"email": "example@gmail.com",
					"password":"root",
				}
			}
		 * @return mixed (token) or (errors)
		 */
		public function authenticate(Request $request) {
			$data = $this->api->parseJsonApiRequestBody($request);

			$status = $this->model->validate($data);
			if ($status->isSuccess()) {
				try {
					$token = $this->auth->jwt->attempt($data);

					if ($token) {
						$status->setMessage('');
						$status->setData(['data' => compact('token')]);
					} else {
						$status->setMessage('User not attempt');
					}
				} catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
					$status->setStatus(500);
				}
			}

			return $this->response::statusResponse($status);
		}

		/**
		 * Register method.
		 * The request is validated by the user repository method, then it is created and then authenticated with JWT
		 * which creates the token. If the token is successfully created, the roles and permssi are assigned to the
		 * user. Return a reply with the user and the token
		 *
		 * @param Request $request
		 * @Request:
		"data": {
		"type": "user",
		"attributes": {
		"email": "example@gmail.com",
		"password":"root",
		"confirm_password":"root"
		}
		}
		 * @return mixed (user + token) or (errors)
		 */
		public function register(Request $request) {
			$data = $this->api->parseJsonApiRequestBody($request);

			$status = $this->model->validate($data, array(
					'email' => 'required|email|unique:users,email|max:255',
					'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
					'confirm_password' => 'required|same:password',
				)
			);

			if ($status->isSuccess()) {
				$status = $this->model->create($data);

				$token = $this->auth->jwt->fromUser($status->data());
				if ($token) {
					$user = $this->api->serializer(new JsonApiSerializer())
						->item($status->data(), new UserTransformer());

					$status->setMessage('');
					$status->setData(['data' => [compact('user', 'token')]]);
				} else {
					$status->setMessage('User not registered');
				}
			}

			return $this->response::statusResponse($status);
		}

		/**
		 * Method for check user authenticated.
		 * Return user playload or Exception
		 *
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function getAuthenticatedUser() {
			return $this->auth->getUser();
		}

		/**
		 * @return mixed
		 */
		public function invalidate() {
			$this->auth->invalidate(true);
			return $this->response->success()->withMessage("Token is invalidated");
		}

		/**
		 * @return mixed
		 */
		public function refresh() {
			$token = $this->auth->refresh(true);
			return $this->response->success()
				->withData($token)
				->withMessage("Token is refreshed");
		}
	}