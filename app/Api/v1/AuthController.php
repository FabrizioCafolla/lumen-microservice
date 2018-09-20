<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 14.48
	 */
	namespace App\Api\v1;

	use Illuminate\Http\Request;

	class AuthController extends ApiBaseController
	{
		private $auth;

		/**
		 * @Var auth instance of Auth service
		 */
		public function __construct()
		{
			parent::__construct();
			$this->auth = app('AuthService');
		}

		public function authenticate(Request $request)
		{
			return $this->auth->authenticate($request);
		}

		public function register(Request $request)
		{
			return $this->auth->registerUser($request);
		}

		public function getAuthenticatedUser()
		{
			return $this->acl->createACL(['admin'], ['prova']);
		}
	}