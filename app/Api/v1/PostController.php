<?php

namespace App\Api\v1;
use App\Models\Post as Post;
use App\Api\v1\ApiBaseController;

/**
 * Post resource representation.
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
	 * Display a listing of resource.
	 *
	 * Get a JSON representation of all posts.
	 *
	 * @Get("/posts")
	 * @Versions({"v1"})
	 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam ..","deleted_at":null})
	 */
	public function index()
	{
		$posts = Post::all();
		return $this->response->array($posts->toArray());
	}

	/**
	 * Show specific post
	 *
	 * Get a JSON representation of the post.
	 *
	 * @Get("/posts/{id}")
	 * @Versions({"v1"})
	 * @Request({"id": "1"})
	 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam ..","deleted_at":null})
	 */
	public function show($id)
	{
		$post = Post::find($id);
		return $this->response->array($post->toArray());
	}

	public function create() {}

	public function store(Request $request) {}

	public function edit($id) {}

	public function update(Request $request, $id) {}

	public function delete($id) {
		$post = Post::find($id);
		if($post){
			$post->delete();
			return $this->success("deleted");
		}
		return $this->error("notFound");
	}
}
