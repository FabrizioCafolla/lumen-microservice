<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 16.51
	 */

	namespace App\Services;


	use App\Facades\AuthFacade;
	use Dingo\Api\Routing\Helpers;
	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;
	use JWTAuth;

	/**
	 * Class ACLService
	 * @package App\Services\ACL
	 */
	class ACLService
	{
		/**
		 * @var Role
		 */
		private $role;

		/**
		 * @var Permission
		 */
		private $permission;


		/**
		 * @var Permission
		 */
		private $response;

		/**
		 * ACLService constructor.
		 */
		public function __construct()
		{
			$this->role = new Role;
			$this->permission = new Permission;

			$this->response = app('ResponseService');
		}

		/** Assign ACL to user return response
		 * @param $user
		 * @param $roles
		 * @param $pemissions
		 * @return mixed
		 */
		public function assignACL($user, $roles, $pemissions)
		{
			if(! $user)
				$this->response->error("notFound");

			$user->assignRole($roles);

			if ($user->hasRole($roles)) {
				$user->givePermissionTo($pemissions);
				return $this->response->success("Added roles and permission to user");
			}
			return $this->response->error("notFound");
		}
		use Helpers;
		/** Create ACL roles and permission into DB
		 * @param $roles
		 * @param $pemissions
		 * @return mixed
		 */
		public function createACL(array $roles, array $pemissions = [])
		{
			$user = JWTAuth::parseToken()->authenticate();

			if (!$user->hasRole('admin')) {
				$role = $this->role->create($roles);

				if (!$pemissions->isEmpty()) {
					$permission = $this->permission->create($pemissions);
					$role->givePermissionTo($permission);
				}

				return $this->response->success("Created roles and permission");
			}
			else
				return $this->response->error("unauthorized", "User logged is not Admin");


		}
	}