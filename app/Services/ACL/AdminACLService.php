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

	class AdminACLService
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

		/** Create ACL roles and permission into DB
		 * @param $roles
		 * @param $pemissions
		 * @return mixed
		 */
		public function createACL($roles, $pemissions)
		{
			$role = $this->role->create($roles);
			$permission = $this->permission->create($pemissions);

			$role->givePermissionTo($permission);

			return $this->response->success("Created roles and permission");

		}
	}