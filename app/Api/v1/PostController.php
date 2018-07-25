<?php

namespace App\Api\v1;
use App\Models\Post as Post;
use App\Api\v1\ApiBaseController;

/**
 * User resource representation.
 *
 * @Resource("Posts", uri="/posts")
 */
class PostController extends ApiBaseController
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
	 * Get a JSON representation of all the registered users.
	 *
	 * @Get("/users/")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam ..","deleted_at":null})
	 */
    public function show($id)
    {
        $post = Post::find($id);
        return $this->response->array($post->toArray());
    }
}
