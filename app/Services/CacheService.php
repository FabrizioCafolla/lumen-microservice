<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use App\Models\User;
	use App\Repositories\CacheRepository;
	use Carbon\Carbon;
	use Illuminate\Support\Facades\Cache;

	class CacheService
	{
		/**
		 * @var CacheService
		 */
		public $cache;

		public function __construct(CacheRepository $cache)
		{
			$this->cache = $cache;
		}

		public function function($method) {
			$this->cache->cache->get('users', function () {
				$users = User::all();
				$expiresAt = Carbon::now()->addDay();
				Cache::store('file')->put('users', $users, $expiresAt);
				return $users;
			});
		}

	}