<?php

	namespace App\Http\REST\v1;

	use App\Helpers\Serializer\KeyArraySerializer;
	use App\Repositories\PostRepository as Post;
	use App\Transformers\PostTransformer;
	use Illuminate\Http\Request;
	use Gate;

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
				$data = $this->api
					->includes('post')
					->serializer(new KeyArraySerializer('posts'))
					->collection($posts, new PostTransformer);
				$response = $this->response->data($data, 200);
				return $response;
			}
			return $this->response->errorNotFound();
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
				$data = $this->api
					->includes('post')
					->serializer(new KeyArraySerializer('post'))
					->item($post, new PostTransformer);

				$response = $this->response->data($data, 200);
				return $response;
			}
			return $this->response->errorNotFound();
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
		public function create()
		{
		}

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
				return $this->response->errorInternal();
			}
			return $validator;
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
		public function edit($id)
		{
		}

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
		public function update(Request $request)
		{
			$post = $this->post->find($request->id);

			if (Gate::denies('posts.update', $post ))
				return $this->response->errorInternal();

			$validator = $this->post->validateRequest($request->all(), "update");

			if ($validator->status() == "200") {
				$task = $this->post->update($request->all(), $request->id);
				if ($task)
					return $this->response->success("Post updated");
				return $this->response->errorInternal();
			}
			return $validator;
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
		public function delete(Request $request)
		{
			$post = $this->post->find($request->id);

			if (Gate::denies('posts.update', $post))
				return $this->response->errorInternal();

			if ($this->post->find($request->id)) {
				$task = $this->post->delete($request->id);
				if ($task)
					return $this->response->success("Post deleted");

				return $this->response->errorInternal();
			}
			return $this->response->errorNotFound();
		}
	}
