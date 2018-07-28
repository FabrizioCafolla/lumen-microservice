<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.18
	 */

	namespace App\Repositories;

	use App\Repositories\Contracts\RepositoryInterface;
	use App\Repositories\Contracts\RepositoryAbstract;
	use Illuminate\Support\Facades\Validator;


	class UserRepository extends RepositoryAbstract
	{
		public static $rules = [
			'email' => 'required|email|unique:users,email|max:255',
			'password' => 'required|min:6|max:20',
			'name' => 'required|min:5|max:255',
			'surname' => 'required|min:5|max:255'
		];

		/**
		 * Specify Model class name
		 *
		 * @return mixed
		 */
		function model()
		{
			return 'App\Models\User';
		}

		public function validateRequest(array $request)
		{
			$rules = self::$rules;

			if(!isset($request)){
				return $this->response("failed",400);
			}

			$validator = Validator::make($request, $rules);
			if ($validator->fails()) {
				return $this->response($validator->errors(),400);
			}

			return $this->response("success",200);
		}
	}