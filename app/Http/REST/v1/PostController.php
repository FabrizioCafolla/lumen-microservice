<?php

	namespace App\Http\REST\v1;

	use App\Http\REST\BaseController;
	use CacheSystem\Serializer\ResponseSerializer;
	use Core\Helpers\Serializer\KeyArraySerializer;
	use App\Repositories\PostRepository as Post;
	use App\Transformers\PostTransformer;
	use Illuminate\Http\Request;
	use Gate;

	/**
	 * Post resource representation.
	 *
	 * @Resource("Posts", uri="/posts")
	 */
	class PostController extends BaseController
	{
		/**
		 * @var User logged
		 */
		private $user;

		/**
		 * @var Post
		 */
		private $repository;

		/**
		 * Initialize @var post
		 *
		 * @Request Post
		 *
		 */
		public function __construct(Post $postRepository)
		{
			parent::__construct();
			$this->user = $this->auth->getUser();
			$this->repository = $postRepository;
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
			$posts = $this->repository->paginate();
			if ($posts) {
				$data = $this->api
					->serializer(new KeyArraySerializer('posts'))
					->paginate($posts, new PostTransformer);

				$response = $this->response()->successData($data);

				if ($responseCached = $this->cache->redis()->get('posts-index'))
					return $responseCached;
				else
					$this->cache->redis()->withSerializer(ResponseSerializer::class)->set('posts-index', $response, 5);

				return $response;
			}
			return $this->response()->errorNotFound();
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
		public function show($postId)
		{
			$post = $this->repository->find($postId);
			if ($post) {
				$data = $this->api
					->serializer(new KeyArraySerializer('post'))
					->item($post, new PostTransformer);

				$response = $this->response()->withLinks($post->getLinks())->successData($data);

				if ($responseCached = $this->cache->redis()->get('posts-show'))
					return $responseCached;
				else
					$this->cache->redis()->withSerializer(ResponseSerializer::class)->set('posts-show', $response, 5);

				return $response;
			}
			return $this->response()->errorNotFound();
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
			$validator = $this->repository->validateRequest($request->all());

			if ($validator->isSuccessful()) {
				$task = $this->repository->create($request->all());
				if ($task) {
					return $this->response()->success("Post created");
				}
				return $this->response()->errorInternal();
			}
			return $validator;
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
			if ($this->user->id != $request->postId)
				return $this->response()->errorUnauthorized();

			$validator = $this->repository->validateRequest($request->all(), "update");

			if ($validator->isSuccessful()) {
				$task = $this->repository->update($request->all(), $request->postId);
				if ($task)
					return $this->response()->success("Post updated");
				return $this->response()->errorInternal();
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
			if ($this->user->id != $request->postId)
				return $this->response()->errorUnauthorized();

			if ($this->repository->find($request->postId)) {
				$task = $this->repository->delete($request->postId);
				if ($task)
					return $this->response()->success("Post deleted");

				return $this->response()->errorInternal();
			}
			return $this->response()->errorNotFound();
		}
	}
