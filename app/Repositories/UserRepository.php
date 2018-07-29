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
		private static $rules = [
			'email' => 'required|email|unique:users,email|max:255',
			'password' => 'required|min:6|max:20',
			'name' => 'required|min:5|max:255',
			'surname' => 'required|min:5|max:255'
		];

		private static $rules_update = [
			'email' => 'required|email|unique:users,email|max:255',
			'name' => 'required|min:5|max:255',
			'surname' => 'required|min:5|max:255'
		];

		private static $rules_password = [
			'password' => 'required|min:6|max:20',
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

		public function validateRequest(array $request, $type, array $rules_specific = [])
		{
			$rules = $this->rules($type, $rules_specific);

			if (!isset($request)) {
				return $this->response("failed", 400);
			}

			$validator = Validator::make($request, $rules);
			if ($validator->fails()) {
				return $this->response($validator->errors(), 400);
			}

			return $this->response("success", 200);
		}

		private function rules($type, array $rules_specific = [])
		{
			if(!empty($rules_specific)){
				return $rules_specific;
			}

			switch ($type) {
				case "store":
				case "create":
					$rules = self::$rules;
					break;
				case "update":
					$rules = self::$rules_update;
					break;
				case "password":
					$rules = self::$rules_password;
					break;
				default:
					$rules = self::$rules;
					break;
			}

			return $rules;
		}
	}