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
		private $user;

		private $response;

		public function __construct(User $user)
		{
			$this->response = app('ResponseService');

			$this->user = $user;
		}

		public function register(Request $request)
		{
			$validator = $this->user->validateRequest($request->all(), "store");

			if ($validator->status() == "200") {
				$user = $this->user->create([
					'email' => $request["email"],
					'password' => $request["password"],
					'name' => $request["name"],
					'surname' => $request["surname"],
				]);

				$token = JWTAuth::fromUser($user);
				if (!$token)
					return $this->response->error("internal");

				return $this->response->custom(compact('user','token'));
			}
			return $this->response->custom($validator->content());
		}

		/**
		 * @param Request $request
		 * @return \Symfony\Component\HttpFoundation\Response
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
	}