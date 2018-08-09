<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 16.51
	 */

	namespace App\Services\ACL;

	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;

	class ACLService
	{

		/**
		 * @var Role
		 */
		public $role;

		/**
		 * @var Permission
		 */
		public $permission;


		/**
		 * @var Permission
		 */
		public $response;

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
	}