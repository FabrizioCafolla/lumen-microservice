<?php

	namespace App\Models;

	use Illuminate\Auth\Authenticatable;
	use Illuminate\Support\Facades\Hash;
	use Laravel\Lumen\Auth\Authorizable;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
	use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
	use ResponseHTTP\Response\Traits\ModelREST;
	use Tymon\JWTAuth\Contracts\JWTSubject;
	use Spatie\Permission\Traits\HasRoles;


	/**
	 * Class User
	 * @package App
	 */
	class User extends Model implements
		AuthenticatableContract,
		AuthorizableContract,
		JWTSubject
	{
		use Authenticatable, Authorizable, HasRoles, ModelREST;
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'email', 'name', 'password', 'surname'
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
			$this->setBasicPath();
			$this->setLinks([
					[
						$this->rel('posts'),
						$this->href('posts'),
						$this->method('GET')
					],
					[
						'self',
						$this->href(),
						$this->method('GET')
					]
				]);
		}

		public function setPasswordAttribute($value)
		{
			$this->attributes['password'] = Hash::make($value);
		}

		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasMany
		 */
		public function post()
		{
			return $this->hasMany('App\Models\Post');
		}

		/**
		 * Get the identifier that will be stored in the subject claim of the JWT.
		 *
		 * @return mixed
		 */
		public function getJWTIdentifier()
		{
			return $this->getKey();
		}

		/**
		 * Return a key value array, containing any custom claims to be added to the JWT.
		 *
		 * @return array
		 */
		public function getJWTCustomClaims()
		{
			return [];
		}
	}
