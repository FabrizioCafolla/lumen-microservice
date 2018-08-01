<?php

namespace App\Api\v1;

use App\Repositories\UserRepository as User;
use App\Services\ApiService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

/**
 * User resource representation.
 *
 * @Resource("Users", uri="/users")
 */
class UserController extends ApiBaseController
{
	/**
	 * @var post
	 */
	private $user;

	public function __construct(ApiService $apiService, User $user)
	{
		parent::__construct($apiService);

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
		$users = $this->user->all();
		if ($users) {
			return $this->api->transform("collection", $users, new UserTransformer);
		}
		return $this->api->error("notFound");
	}

	/**
	 * Show a specific user
	 *
	 * Get a JSON representation of get user.
	 *
	 * @Get("/user/{id}")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."})
	 */
	public function show($id){
		$user = $this->user->find($id);
		if ($user) {
			return $this->api->transform("item", $user, new UserTransformer);
		}
		return $this->api->error("notFound");
	}

	public function create() {}

	/**
	 * Create a new post
	 *
	 * Get a JSON representation of new user.
	 *
	 * @Post("/user")
	 * @Versions({"v1"})
	 * @Request(body={"email":"lavonne.cole@hermann.com", "password" : "a24fag4", "name":"Amelie Trantow","surname":"Kayley Klocko Sr."})
		 * @Response(200, success or error)
	 */
	public function store(Request $request) {
		$validator = $this->user->validateRequest($request->all(), "store");

		if ($validator->status() == "200") {
			$task = $this->user->create($request->all());
			if ($task) {
				return $this->api->success("created");
			}
			return $this->api->error("internal");
		}
		return $this->api->custom($validator->content());
	}

	public function edit($id) {}

	/**
	 * Update post
	 *
	 * Get a JSON representation of update user.
	 *
	 * @Put("/user/{id}")
	 * @Versions({"v1"})
	 * @Request(array -> {"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr."}, id)
		 * @Response(200, success or error)
	 */
	public function update(Request $request, $id) {
		$validator = $this->user->validateRequest($request->all(), "update");

		if ($validator->status() == "200") {
			$task = $this->user->update($request->all(), $id);
			if ($task) {
				return $this->api->success("updated");
			}
			return $this->api->error("internal");
		}
		return $this->api->custom($validator->content());
	}

	/**
	 * Show a specific user
	 *
	 * Get a JSON representation of get user.
	 *
	 * @Delete("/user/{id}")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, success or error)
	 */
	public function delete($id) {
		if ($this->user->find($id)) {
			$task = $this->user->delete($id);
			if($task)
				return $this->api->success("deleted");

			return $this->api->error("internal");
		}
		return $this->api->error("notFound");
	}
}
