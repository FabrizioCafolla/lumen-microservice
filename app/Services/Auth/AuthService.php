<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 11.33
	 */

	namespace App\Services\Auth;

	use App\Repositories\UserRepository as User;
	use App\Services\Auth\Contracts\AuthServiceAbstract;
	use Illuminate\Http\Request;

	class AuthService extends AuthServiceAbstract

	{
		/**
		 * AuthService constructor.
		 * @param User $user
		 */
		public function __construct()
		{
			parent::__construct(User::class);
		}

		/**
		 * @param Request $request
		 * @return mixed
		 */
		public function registerUser(Request $request)
		{
			$response = $this->register($request);

			//assign Role and Permission to User created
			if ($response->status() == 200) {
				$data = $response->getData(true);
				$user = $this->auth->find($data["user"]["id"]);

				$this->acl->assignACL($user,'user','read write publish');
			}

			return $response;
		}

	}