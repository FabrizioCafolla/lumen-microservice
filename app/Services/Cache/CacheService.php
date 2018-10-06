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

		/**
		 * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
		 *
		 * use into controller: $this->cache->file()-> any method that class implement
		 *
		 * @return \Illuminate\Cache\CacheManager
		 */
		public function file(){
			return $this->file->file();
		}

		/**
		 * This method returns the class to be able to use the primitive methods and not those implemented by the Reids Cache Repository
		 *
		 * use into controller: $this->cache->redis()-> any method that class implement
		 *
		 * @return Redis
		 */
		public function redis(){
			return $this->file->redis();
		}
	}