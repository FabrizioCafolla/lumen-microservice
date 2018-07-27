<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/07/18
	 * Time: 12.52
	 */

	namespace App\Transformers;

	use App\Models\Post;
	use League\Fractal\TransformerAbstract;
	use App\Transformers\UserTransformer;

	class PostTransformer extends TransformerAbstract
	{
		protected $availableIncludes = [
			'user'
		];

		public function transform(Post $post)
		{
			return [
				'id' => $post->id,
				'title' => $post->title,
				'description' => $post->description,
				'status' => $post->status,
				'created_at' => $post->created_at->format('d-m-Y')
			];
		}

		public function includeUser(Post $post)
		{
			return $this->item($post->user, new UserTransformer);
		}
	}