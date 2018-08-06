<?php

namespace App\Api\v1;

use App\Repositories\UserRepository as User;
use App\Transformers\UserTransformer;

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
		$users = $this->user->all();
		if ($users) {
			return $this->api->transform("collection", $users, new UserTransformer);
		}
		return $this->response->error("notFound");
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
		return $this->response->error("notFound");
	}

	/**
	 * Edit
	 *
	 * Get a JSON representation of update.
	 *
	 * @Get /{id}/edit
	 * @Versions
	 * @Request {id}
	 * @Response
	 */
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
	public function update($id) {
		$validator = $this->user->validateRequest($this->request->all(), "update");

		if ($validator->status() == "200") {
			$task = $this->user->update($this->request->all(), $id);
			if ($task) {
				return $this->response->success("User updated");
			}
			return $this->response->error("internal");
		}
		return $this->response->custom($validator->content());
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
				return $this->response->success("User deleted");

			return $this->response->error("internal");
		}
		return $this->response->error("notFound");
	}
}
