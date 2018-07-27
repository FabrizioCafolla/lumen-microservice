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
		public static $rules = [
			'user_id' => 'required|exists:users,id',
			'status' => 'required',
			'title' => 'required|min:5|max:255',
			'description' => 'required|min:5|max:255'
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