<?php

namespace App\Api\v1;

use App\Api\v1\ApiBaseController;
use App\Repositories\UserRepository as User;
use App\Transformers\UserTransformer;
use League\Fractal;

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

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of resource.
	 *
	 * Get a JSON representation of all users.
	 *
	 * @Get("/posts")
	 * @Versions({"v1"})
	 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr.","remember_token":null})
	 */
	public function index()
	{

		$users = $this->user->all();
		if ($users) {
			return $this->transform("collation", $users, new UserTransformer, [], null, ['post']);
		}
		return $this->error("notFound");
	}

	/**
	 * Show a specific user
	 *
	 * Get a JSON representation of get user.
	 *
	 * @Get("/users/{id}")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr.","remember_token":null})
	 */
	public function show($id){
		$user = $this->user->find($id);
		if ($user) {
			return $this->transform("item", $user, new UserTransformer, [], null, ['post']);
		}
		return $this->error("notFound");
	}

	public function create() {}

	public function store(Request $request) {}

	public function edit($id) {}

	public function update(Request $request, $id) {}

	public function delete($id) {}
}
