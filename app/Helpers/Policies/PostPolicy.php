<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/10/18
	 * Time: 18.25
	 */

	namespace App\Helpers\Policies;


	use App\Models\Post;
	use App\Models\User;
	use Illuminate\Http\Request;

	class PostPolicy extends AbstractPolicy
	{
		/**
		 * Determine if the given post can be updated by the user.
		 *
		 * @param User $user
		 * @param Post $post
		 * @return bool
		 */
		public function update(User $user, Post $post)
		{
			return $this->checkId($user->id, $post->user_id);
		}

		/**
		 * Determine if the given post can be deleted by the user.
		 *
		 * @param User $user
		 * @param Post $post
		 * @return bool
		 */
		public function delete(User $user, Post $post)
		{
			return $this->checkId($user->id, $post->user_id);
		}
	}