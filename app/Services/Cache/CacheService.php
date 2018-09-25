<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services\Cache;

	use App\Services\Cache\CacheRepository\FileService;
	use App\Services\Cache\CacheRepository\RedisService;

	/**
	 * Class CacheService
	 * @package App\Services\Cache
	 */
	class CacheService
	{
		/**
		 * @var FileService
		 */
		public $file;

		/**
		 * @var RedisService
		 */
		public $redis;

		/**
		 * CacheService constructor.
		 * @param FileService $fileService
		 * @param RedisService $redisService
		 */
		public function __construct(FileService $fileService, RedisService $redisService)
		{
			$this->file = $fileService;
			$this->redis = $redisService;
		}
	}