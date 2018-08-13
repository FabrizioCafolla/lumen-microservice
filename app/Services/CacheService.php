<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use Carbon\Carbon;
	use Illuminate\Contracts\Cache\Repository as CacheRepository;

	class CacheService
	{
		/**Use method for storage cache in file
		 *
		 * @var CacheService
		 */
		public $file;

		/**
		 * CacheService constructor.
		 * @param CacheRepository $cache
		 * @return CacheRepository for instance in
		 */
		public function __construct(CacheRepository $cache)
		{
			$this->file = $cache;
		}
	}