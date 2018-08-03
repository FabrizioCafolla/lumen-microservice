<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 14.48
	 */
	namespace App\Http\Controllers;


	use Illuminate\Http\Request;
	use Tymon\JWTAuth\JWTAuth;
	use Tymon\JWTAuth\Exceptions\JWTException;

	class AuthController extends Controller
	{
		/**
		 * @var JWTAuth
		 */
		private $auth;
		/**
		 * @param JWTAuth $auth
		 */
		public function __construct(JWTAuth $auth)
		{
			parent::__construct();

			$this->auth = $auth;
		}
		/**
		 * @param Request $request
		 * @return \Symfony\Component\HttpFoundation\Response
		 */
		public function authenticate(Request $request)
		{
			// grab credentials from the request
			$credentials = $request->json()->all();
			try {
				// attempt to verify the credentials and create a token for the user
				$token = $this->auth->attempt($credentials);
				if (!$token) {
					return response()->json(['error' => 'invalid_credentials'], 401);
				}
			} catch (JWTException $e) {
				// something went wrong whilst attempting to encode the token
				return response()->json(['error' => 'could_not_create_token'], 500);
			}
			// all good so return the token
			return response()->json(compact('token'));
		}
	}