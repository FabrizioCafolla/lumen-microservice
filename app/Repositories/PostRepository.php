<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 26/07/18
	 * Time: 19.19
	 */

	namespace App\Repositories;

	use App\Repositories\Contracts\RepositoryInterface;
	use App\Repositories\Contracts\RepositoryAbstract;
	use Illuminate\Support\Facades\Validator;

	class PostRepository extends RepositoryAbstract
	{
		private static $rules = [
			'user_id' => 'required|exists:users,id',
			'status' => 'required',
			'title' => 'required|min:5|max:255',
			'description' => 'required|min:5|max:255'
		];

		private static $rules_update = [
			'user_id' => 'exists:users,id',
			'status' => 'required',
			'title' => 'min:5|max:255',
			'description' => 'min:5|max:255'
		];

		/**
		 * Specify Model class name
		 *
		 * @return mixed
		 */
		function model()
		{
			return 'App\Models\Post';
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
				default:
					$rules = self::$rules;
					break;
			}
			return $rules;
		}
	}