<?php

	namespace App\Http\REST\v1;

	use App\Helpers\Serializer\KeyArraySerializer;
	use App\Repositories\UserRepository as User;
	use App\Transformers\UserTransformer;
	use Gate;
	use Illuminate\Http\Request;

	/**
	 * User resource representation.
	 *
	 * @Resource("Users", uri="/users")
	 */
	class UserController extends ApiBaseController
	{
		/**
		 * @var User
		 */
		private $user;

		/**
		 * UserController constructor.
		 * @param User $user
		 */
		public function __construct(User $user)
		{
			parent::__construct();
			$this->user = $user;
		}

		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all users.
		 *
		 * @Get("/users")
		 * @Versions({"v1"})
		 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."})
		 */
		public function index()
		{
			$users = $this->user->paginate();

			if ($users) {
				$data = $this->api
					->includes('posts')
					->serializer(new KeyArraySerializer('users'))
					->paginate($users, new UserTransformer());

				$response = $this->response->data($data, 200);
				return $response;
			}
			return $this->response->error("errorNotFound");
		}

		/**
		 * Show a specific user
		 *
		 * Get a JSON representation of get user.
		 *
		 * @Get("/users/{id}")
		 * @Versions({"v1"})
		 * @Request({"id": "1"})
		 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."})
		 */
		public function show($id)
		{
			$user = $this->user->find($id);
			if ($user) {
				$data = $this->api
					->includes('post')
					->serializer(new KeyArraySerializer('user'))
					->item($user, new UserTransformer);

				$response = $this->response->data($data, 200);
				return $response;
			}
			return $this->response->error("errorNotFound");
		}

		/**
		 * Update user
		 *
		 * Get a JSON representation of update user.
		 *
		 * @Put("/users/{id}")
		 * @Versions({"v1"})
		 * @Request(array -> {"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."}, id)
		 * @Response(200, success or error)
		 */
		public function update(Request $request)
		{
			if (Gate::denies('users.update', $request))
				return $this->response->error("errorInternal");

			$validator = $this->user->validateRequest($request->all(), "update");
			if ($validator->status() == "200") {
				$task = $this->user->updateUser($request->all(), $request->id);
				if ($task)
					return $this->response->success("User updated");
				return $this->response->error("errorInternal");
			}
			return $validator;
		}

		/**
		 * Update user password
		 *
		 * Get a JSON representation of update user.
		 *
		 * @Put("/users/{id}/password")
		 * @Versions({"v1"})
		 * @Request(array -> {"password":"xAdsavad$"}, id)
		 * @Response(200, success or error)
		 */
		public function updatePassword(Request $request)
		{
			if (Gate::denies('users.update', $request))
				return $this->response->error("errorInternal");

			$validator = $this->user->validateRequest($request->only(['password', 'confirm_password']), "password");

			if ($validator->status() == "200") {
				$task = $this->user->updateUser($request->only('password'), $request->id);
				if ($task)
					return $this->response->success("User updated");
				return $this->response->error("errorInternal");
			}
			return $validator;
		}

		/**
		 * Delete a specific user
		 *
		 * Get a JSON representation of get user.
		 *
		 * @Delete("/users/{id}")
		 * @Versions({"v1"})
		 * @Request({"id": "1"})
		 * @Response(200, success or error)
		 */
		public function delete(Request $request)
		{
			if (Gate::denies('users.delete', $request))
				return $this->response->error("errorInternal");

			$task = $this->user->delete($request->id);
			if ($task)
				return $this->response->success("User deleted");

			return $this->response->error("errorInternal");
		}
	}
