<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.18
	 */

	namespace App\Repositories;

	use App\Repositories\Eloquent\RepositoryAbstract;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Support\Facades\Validator;
	use JWTAuth;


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

		public function register(array $request) {

			$validator = $this->validateRequest($request, 'store');
			if (!$validator->isSuccessful()) {
				return $this->response->error("generic", $validator);
			}

			$user = $this->create([
				'email'     => $request["email"],
				'password'  => $request["password"],
				'name'      => $request["name"],
				'surname'  => $request["surname"],
			]);

			$token = JWTAuth::fromUser($user);
			return response()->json(compact('token'));
		}

		public function validateRequest(array $request, $type, array $rules_specific = [])
		{
			$rules = $this->rules($type, $rules_specific);

			if (!isset($request)) {
				return $this->response->error("badRequest");
			}

			$validator = Validator::make($request, $rules);
			if ($validator->fails()) {
				return $this->response->error("generic", $validator->errors());
			}

			return $this->response->success("Rules validate success");
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