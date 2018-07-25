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
	 * Show all users
	 *
	 * Get a JSON representation of get user.
	 *
	 * @Get("/users/")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, body={"id":1,"email":"lavonne.cole@hermann.com","name":"Amelie Trantow","surname":"Kayley Klocko Sr.","remember_token":null})
	 */
	public function show($id){
		$user = User::find($id);
		return $this->response->array($user->toArray());
	}
}
