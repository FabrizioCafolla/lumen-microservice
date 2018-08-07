<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 16.51
	 */

	namespace App\Services;

	use Spatie\Permission\Models\Role;
	use App\Models\User;
	use Spatie\Permission\Models\Permission;

	class PermissionService {

		/**
		 * @var Role
		 */
		private $role;

		/**
		 * @var Permission
		 */
		private $permission;

		/**
		 * @var User
		 */
		private $user;

		public function __construct()
		{
			$this->role = new Role;
			$this->permission = new Permission;
			$this->user = new User;
		}
	}