<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 10/08/18
	 * Time: 13.10
	 */

	namespace App\Services\ACL\Contracts;

	use Spatie\Permission\Models\Role;
	use Spatie\Permission\Models\Permission;

	abstract class ACLAbstract
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
	}