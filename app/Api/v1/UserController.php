<?php

namespace App\Api\v1;
use App\Models\User as User;
use App\Api\v1\ApiBaseController;

/**
 * User resource representation.
 *
 * @Resource("Users", uri="/users")
 */
class UserController extends ApiBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

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
		$users = User::all();
		return $this->response->array($users->toArray());
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
		$user = User::find($id);
		return $this->response->array($user->toArray());
	}

	public function create() {}

	public function store(Request $request) {}

	public function edit($id) {}

	public function update(Request $request, $id) {}

	public function delete($id) {
		$user = User::find($id);
		if($user){
			$user->delete();
			return $this->success("deleted");
		}
		return $this->error("notFound");
	}
}
