<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 06/08/18
	 * Time: 16.51
	 */

	namespace App\Services;

	use Spatie\Permission\Exceptions\PermissionAlreadyExists;
	use Spatie\Permission\Exceptions\PermissionDoesNotExist;
	use Spatie\Permission\Exceptions\RoleAlreadyExists;
	use Spatie\Permission\Exceptions\RoleDoesNotExist;
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
		public function assign($user, array $roles = [], array $permissions = [], $sync = false)
		{
			if ($this->check($user, ['roles' => $roles]))
				return $this->response->error("generic", "User already has one of these roles " . $roles);

			if ($this->check($user, ['permissions' => $permissions]))
				return $this->response->error("generic", "User already has one of these permissions " . $permissions);

			try {
				if ($sync) {
					$roles ? $user->syncRoles($roles) : null;
					$permissions ? $user->syncPermissions($permissions) : null;
				} else {
					$user->assignRole($roles);
					$user->givePermissionTo($permissions);
				}

				return $this->response->success("Assigned successful to user id: " . $user->id);

			} catch (RoleDoesNotExist $e) {
				foreach ($roles as $role) {
					$this->role->findByName($role);
				}
			} catch (PermissionDoesNotExist $e) {
				foreach ($permissions as $permission) {
					$this->permission->findByName($permission);
				}
			}
			return $this->response->error("notFound");
		}

		public function check($user, array $data) :bool
		{
			$checkedRoles = array_get($data, 'roles', 0);
			if ($checkedRoles && $user->hasAnyRole($data))
				return true;

			$checkedPermissions = array_get($data, 'permissions', 0);
			if ($checkedPermissions && $user->hasAnyPermission($checkedPermissions))
				return true;

			return false;
		}

		/**
		 * Method for create Role and Permission in DB
		 * This function can be used by default only by Admin, but it is possible to change or choose to remove this restriction.
		 * Example of the array to pass ["nameRole" => "namePermission", "nameRole1" => "namePermission2"]
		 * For more information follow the official spatie guide
		 *
		 * @param array $roles
		 * @return static
		 */
		public function create(array $roles)
		{
			$user = JWTAuth::user();

			if (!$user->hasRole('admin'))
				return $this->response->error("unauthorized", "User logged is not Admin");

			foreach ($roles as $role => $permission) {
				try {
					$createdRole = $this->role->create(['name' => $role]);

					if ($permission) {
						$createdPermission = $this->permission->create(['name' => $permission]);
						$createdRole->givePermissionTo($createdPermission);
					}
				} catch (PermissionAlreadyExists $e) {
					return $e->create($permission, 'api');
				} catch (RoleAlreadyExists $e) {
					return $e->create($role, 'api');
				}
			}
			return $this->response->success("Created roles and permission");
		}
	}