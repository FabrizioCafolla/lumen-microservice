<?php

	namespace App\Api\v1;

	use App\Repositories\PostRepository as Post;
	use Illuminate\Http\Request;
	use App\Transformers\PostTransformer;

	/**
	 * Post resource representation.
	 *
	 * @Resource("Posts", uri="/posts")
	 */
	class PostController extends ApiBaseController
	{
		/**
		 * @var Post
		 */
		private $post;

		/**
		 * Initialize @var post
		 *
		 * @Request Post
		 *
		 */
		public function __construct(Post $post)
		{
			parent::__construct();
			$this->post = $post;
		}

		/**
		 * Display a listing of resource.
		 *
		 * Get a JSON representation of all posts.
		 *
		 * @Get("/posts")
		 * @Versions({"v1"})
		 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam .."})
		 */
		public function index()
		{
			$posts = $this->post->all();
			if ($posts) {
				return $this->api->transform("collection", $posts, new PostTransformer);
			}
			return $this->response->error("notFound");
		}

		/**
		 * Show specific post
		 *
		 * Get a JSON representation of the post.
		 *
		 * @Get("/post/{id}")
		 * @Versions({"v1"})
		 * @Request({"id": "1"})
		 * @Response(200, body={"id":1,"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam .."})
		 */
		public function show($id)
		{
			$post = $this->post->find($id);
			if ($post) {
				return $this->api->transform("item", $post, new PostTransformer);

			}
			return $this->response->error("notFound");
		}

		/**
		 * Create
		 *
		 * Get a JSON representation of item .
		 *
		 * @Get /create
		 * @Versions
		 * @Request()
		 * @Response
		 */
		public function create() {}

		/**
		 * Create a new post
		 *
		 * Get a JSON representation of new post.
		 *
		 * @Post("/post")
		 * @Versions({"v1"})
		 * @Request(array -> {"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam .."})
		 * @Response(200, success or error)
		 */
		public function store(Request $request)
		{
			$validator = $this->post->validateRequest($request->all());

			if ($validator->status() == "200") {
				$task = $this->post->create($request->all());
				if ($task) {
					return $this->response->success("Post created");
				}
				return $this->response->error("internal");
			}
			return $this->response->custom($validator->content());
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
		 * Get a JSON representation of update post.
		 *
		 * @Put("/post/{id}")
		 * @Versions({"v1"})
		 * @Request(array -> {"user_id":6,"status":"{\"status\": \"active\"}","title":"Dolore quis...","description":"Expedita et quam .."}, id)
		 * @Response(200, success or error)
		 */
		public function update(Request $request, $id)
		{
			$validator = $this->post->validateRequest($request->all());

			if ($validator->status() == "200") {
				$task = $this->post->update($request->all(), $id);
				if ($task) {
					return $this->response->success("Post updated");
				}
				return $this->response->error("internal");
			}
			return $this->response->custom($validator->content());
		}

		/**
		 * Delete a post
		 *
		 * Get a JSON representation of delete post.
		 *
		 * @Delete("/post/{id}")
		 * @Versions({"v1"})
		 * @Request(id)
		 * @Response(200, success or error)
		 */
		public function delete($id)
		{
			if ($this->post->find($id)) {
				$task = $this->post->delete($id);
				if($task)
					return $this->response->success("Post deleted");

				return $this->response->error("internal");
			}
			return $this->response->error("notFound");
		}
	}
