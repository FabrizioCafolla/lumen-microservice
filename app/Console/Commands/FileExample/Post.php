<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/07/18
	 * Time: 21.23
	 */

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Post extends Model
	{
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'user_id', 'status', 'title', 'description'
		];

		/**
		 * The attributes excluded from the model's JSON form.
		 *
		 * @var array
		 */
		protected $hidden   = ['created_at', 'updated_at'];

		public function user()
		{
			return $this->belongsTo('App\Models\User');
		}

	}
