<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 16.51
	 */

	namespace App\Services\ACL;

	use App\Services\ACL\Contracts\ACLAbstract;

	class AdminACLService extends ACLAbstract
	{
		/**
		 * ACLService constructor.
		 */
		public function __construct()
		{
			parent::__construct();
		}

		/** Create ACL roles and permission into DB
		 * @param $roles
		 * @param $pemissions
		 * @return mixed
		 */
		public function createACL(array $roles, array $pemissions)
		{
			$role = $this->role->create($roles);
			$permission = $this->permission->create($pemissions);

			$role->givePermissionTo($permission);

			return $this->response->success("Created roles and permission");

		}
	}