<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 25/07/18
	 * Time: 21.23
	 */

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use ResponseHTTP\Response\Traits\ModelREST;

	class Post extends Model
	{
		use ModelREST;
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
		protected $hidden = ['created_at', 'updated_at'];

		public function __construct(array $attributes = [])
		{
			$this->bootREST();
			parent::__construct($attributes);
		}

		private function bootREST()
		{
			$this->setBasicUri();
			$this->setLinks([
				[
					$this->rel('users'),
					$this->href('users'),
					$this->method('GET')
				],
				[
					'self',
					$this->href(),
					$this->method('GET')
				]
			]);
		}

		public function user()
		{
			return $this->belongsTo('App\Models\User');
		}
	}
