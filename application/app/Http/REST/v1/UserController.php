<?php

	namespace App\Http\REST\v1;

	use App\Http\REST\BaseController;
	use CacheSystem\Serializer\ResponseSerializer;
	use Core\Helpers\Serializer\KeyArraySerializer;
	use App\Repositories\UserRepository as User;
	use App\Transformers\UserTransformer;
	use Illuminate\Http\Request;

	/**
	 * User resource representation.
	 *
	 * @Resource("Users", uri="/users")
	 */
	class UserController extends BaseController
	{
		/**
		 * @var User logged
		 */
		private $user;

		/**
		 * @var \App\Repositories\UserRepository
		 */
		private $repository;

		/**
		 * UserController constructor.
		 *
		 * @param User $user
		 */
		public function __construct(User $userRepository)
		{
			parent::__construct();
			$this->user = $this->auth->getUser();
			$this->repository = $userRepository;
		}

		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all users.
		 *
		 * @Get("/users")
		 * @Versions({"v1"})
		 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley
         *                Klocko Sr."})
         * @return \Illuminate\Http\JsonResponse|\ResponseHTTP\Response\HttpResponse
		 */
		public function index()
		{
			$users = $this->repository->paginate();

			if ($users) {
				$data = $this->api
					->serializer(new KeyArraySerializer('users'))
					->paginate($users, new UserTransformer());

				$response = $this->response()->successData($data);

				if ($responseCached = $this->cache->redis()->get('users-index'))
					return $responseCached;
				else
					$this->cache->redis()->withSerializer(ResponseSerializer::class)->set('users-index', $response, 1);

				return $response;
			}
			return $this->response()->errorNotFound();
		}

		/**
		 * Show a specific user
		 *
		 * Get a JSON representation of get user.
		 *
		 * @Get("/users/{id}")
		 * @Versions({"v1"})
		 * @Request({"id": "1"})
		 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley
         *                Klocko Sr."})
         * @param $id
		 *
		 * @return $this|\Illuminate\Http\JsonResponse|\ResponseHTTP\Response\HttpResponse
		 */
		public function show($id)
		{
			$user = $this->repository->find($id);
			if ($user) {
				$data = $this->api
					->serializer(new KeyArraySerializer('user'))
					->item($user, new UserTransformer);

				$response = $this->response()->withLinks($user->getLinks(), false)->successData($data);

				if ($responseCached = $this->cache->file()->get('users-show'))
					return $responseCached;
				else
					$this->cache->file()->withSerializer(ResponseSerializer::class)->put('users-show', $response, 1);

				return $response;
			}
			return $this->response()->errorNotFound();
		}

		/**
		 * Update user
		 *
		 * Get a JSON representation of update user.
		 *
		 * @Put("/users/{id}")
		 * @Versions({"v1"})
		 * @Request(array -> {"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko
         *                Sr."}, id)
         * @Response(200, success or error)
		 */
		public function update(Request $request)
		{
			if ($this->user->id != $request->id)
				return $this->response()->errorUnauthorized();

			$validator = $this->repository->validateRequest($request->all(), "update");
			if ($validator->isSuccessful()) {
				$task = $this->repository->updateUser($request->all(), $request->id);
				if ($task)
					return $this->response()->success("User updated");
				return $this->response()->errorInternal();
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
			if ($this->user->id != $request->id)
				return $this->response()->errorUnauthorized();

			$validator = $this->repository->validateRequest($request->only(['password', 'confirm_password']), "password");

			if ($validator->isSuccessful()) {
				$task = $this->repository->updateUser($request->only('password'), $request->id);
				if ($task)
					return $this->response()->success("User updated");
				return $this->response()->errorInternal();
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
			if ($this->user->id != $request->id)
				return $this->response()->errorUnauthorized();

			$task = $this->repository->delete($request->id);
			if ($task)
				return $this->response()->success("User deleted");

			return $this->response()->errorInternal();
		}
	}
