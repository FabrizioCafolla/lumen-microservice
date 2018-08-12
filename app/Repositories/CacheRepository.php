<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 12/08/18
	 * Time: 21.20
	 */

	namespace App\Repositories;

	use Illuminate\Contracts\Cache\Repository;

	class CacheRepository
	{
		public $cache;

		public function __construct(Repository $cache)
		{
			$this->cache = $cache;
		}
	}