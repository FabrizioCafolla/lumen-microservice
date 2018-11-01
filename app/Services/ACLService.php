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

			$this->response = app('service.response');
		}

		/**
		 * Method for assigning roles or permissions to a user.
		 * The parameters are simple arrays, with the possibility to use the sync method (optional),
		 * a failure response is returned if one of the roles or permissions are already assigned to the user,
		 * otherwise a successful answer occurs, in addition there are exceptions if the roles or permissions you wish to assign are not present in the system
		 *
		 * @param $user
		 * @param array $roles
		 * @param array $permissions
		 * @param bool $sync
		 * @return mixed
		 */
		public function assign($user, array $roles = [], array $permissions = [], $sync = false)
		{
			if ($this->check($user, ['roles' => $roles]))
				return $this->response->error("User already has one of these roles " . $roles);

			if ($this->check($user, ['permissions' => $permissions]))
				return $this->response->error("User already has one of these permissions " . $permissions);

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
		}

		/**
		 * Method to check if a user has permissions or roles already assigned.
		 * The parameters passed are three the first is User, the second is an array that can be composed in these three ways:
		 * 1) ["roles" => ["role1", "role2", "roleN"]] or ["roles" => "role1"]
		 * 2) ["permissions" => ["permission1", "permission2", "permissionN"]] or ["permissions" => "permission"]
		 * 3) It is possible to put the two keys together in the array
		 * The third parameter is the choice to check if the user is in possession of all the roles or permissions.
		 * The true result is determined by the fact that a role or permission is already assigned to the user, it returns false if the user does not own any of those roles or permissions.
		 *
		 * @param $user
		 * @param array $data
		 * @return bool
		 */
		public function check($user, array $data, $all = false): bool
		{
			$checkedRoles = array_get($data, 'roles', 0);
			if ($checkedRoles && ($all ? $user->hasAllRoles($data) : $user->hasAnyRole($data)))
				return true;

			$checkedPermissions = array_get($data, 'permissions', 0);
			if ($checkedPermissions && ($all ? $user->hasAllPermissions($data) : $user->hasAnyPermission($checkedPermissions)))
				return true;

			return false;
		}

		/**
		 * Method for create Role and Permission in DB
		 * This function can be used by default only by Admin, but it is possible to change or choose to remove this restriction.
		 * Example of the array to pass ["role1", "role2", "roleN"] or ["permission1", "permission2", "permissionN"]
		 * For more information follow the official spatie guide
		 *
		 * tip: Use this function only if the logged in user is admin or in methods that are only called by the internal system
		 *
		 * @param array $roles
		 * @param array $permissions
		 * @param string $guard
		 * @return static
		 */
		public function create(array $roles = [], array $permissions = [], $guard = 'api')
		{
			foreach ($roles as $role) {
				try {
					$this->role->create(['guard_name' => $guard, 'name' => $role]);
				} catch (RoleAlreadyExists $e) {
					return $e->create($role, 'api');
				}
			}
			foreach ($permissions as $permission) {
				try {
					$this->permission->create(['guard_name' => $guard, 'name' => $permission]);
				} catch (PermissionAlreadyExists $e) {
					return $e->create($permission, 'api');
				}
			}
			return $this->response->success("Roles and Permissions successful created");
		}

		/**
		 * Assigning permissions to roles.
		 * If roles not exist are created.
		 * Example of the array to pass:
		 * ["nameRole" => "namePermission", "nameRole1" => "namePermission2"]
		 * or ["nameRole" => ["namePermission", namePermission2"]]
		 * or ["nameRole" => ["namePermission", namePermission2"], "nameRole1" => "namePermission",]
		 * For more information follow the official spatie guide
		 *
		 * tip: if permissions into array are set to null and sync parameter is true, the Role are remove all permissions assigned
		 * tip: Use this function only if the logged in user is admin or in methods that are only called by the internal system
		 *
		 * @param array $roles
		 * @return static
		 */
		public function give(array $roles, $sync = false)
		{
			foreach ($roles as $role => $permission) {
				try {
					$giveRole = $this->role->findOrCreate($role);
					if ($sync)
						$giveRole->syncPermissions($permission);
					else
						$giveRole->givePermissionTo($permission);
				} catch (PermissionDoesNotExist $e) {
					return $e->create($permission, 'api');
				}
			}
			return $this->response->success("Assigned successful");
		}
	}