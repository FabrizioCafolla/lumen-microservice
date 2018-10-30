<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 27/07/18
	 * Time: 12.52
	 */

	namespace App\Transformers;

	use App\Models\User;
	use League\Fractal\TransformerAbstract;

	class UserTransformer extends TransformerAbstract
	{
		protected $availableIncludes = [
			'posts'
		];

		protected $defaultIncludes = [];

		/**
		 * @Request User
		 * @Response array
		 */
		public function transform(User $user)
		{
			return [
				'id' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'surname' => $user->surname,
			];
		}

		public function includePosts(User $user)
		{
			$posts = $user->post()->get();
			return $this->collection($posts, new PostTransformer, -1); //resourceKey -1 if you want to exclude arrayKey from the data included by the transformer when use KeyArraySerializer
		}
	}