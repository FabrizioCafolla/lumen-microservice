<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.18
	 */

	namespace App\Repositories;

	use App\Repositories\Eloquent\RepositoryAbstract;
	use Illuminate\Container\Container as App;
	use Illuminate\Support\Facades\Hash;
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
			'email' => 'email|unique:users,email|max:255',
			'name' => 'required|min:5|max:255',
			'surname' => 'min:5|max:255'
		];

		private static $rules_password = [
			'password' => 'required|min:6|max:20',
			'confirm_password' => 'required|same:password'
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

		/**
		 * @param array $data
		 * @param $id
		 * @param string $attribute
		 * @return mixed
		 */
		public function updateUser(array $data, $id, $attribute="id") {
			if(array_has($data, 'password'))
				data_set($data, 'password', Hash::make($data["password"]));

			$response = $this->update($data,  $id, $attribute);
			return $response;
		}

		/** Validate request api
		 *
		 * @param array $request
		 * @param $type
		 * @param array $rules_specific
		 * @return \Illuminate\Http\JsonResponse
		 */
		public function validateRequest(array $request, $type, array $rules_specific = [])
		{
			$rules = $this->rules($type, $rules_specific);

			if (!isset($request)) {
				return $this->response->error("errorBadRequest");
			}

			$validator = Validator::make($request, $rules);
			if ($validator->fails()) {
				return $this->response->error("errorValidator", $validator->errors());
			}

			return $this->response->success("Rules validate success");
		}

		/** Use rules based on request
		 *
		 * @param $type
		 * @param array $rules_specific
		 * @return array
		 */
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