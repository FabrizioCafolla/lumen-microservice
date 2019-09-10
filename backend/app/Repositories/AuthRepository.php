<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.18
	 */

	namespace App\Repositories;

	use App\Models\User;
	use Kosmosx\Framework\Repository\Eloquent\RepositoryStatusAbstract;

	class AuthRepository extends RepositoryStatusAbstract
	{
		public $RULES = array(
			'email' => 'required|email',
			'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
		);

		/**
		 * Specify Model class name
		 *
		 * @return mixed
		 */
		function model(): string
		{
			return User::class;
		}
	}