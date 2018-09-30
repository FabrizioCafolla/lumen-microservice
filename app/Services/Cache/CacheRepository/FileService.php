<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services\Cache\CacheRepository;

	use App\Services\Cache\CacheAbstract\CacheAbstract;
	use Illuminate\Cache\CacheManager;

	/**
	 * Class FileService
	 * @package App\Services\Cache\CacheRepository
	 */
	class FileService extends CacheAbstract
	{
		/**Use method for storage cache in file
		 *
		 * @var CacheServsice
		 */
		private $file;

		/**
		 * CacheService constructor.
		 * @param CacheRepository $cache
		 * @return CacheRepository for instance in
		 */
		public function __construct(CacheManager $cache)
		{
			$this->file = $cache;
		}

		/**
		 * Method for creating multiple items in the cache
		 * Example ['key' => $value, 'key2' => $value2]
		 *
		 * @param array $values
		 * @param $type
		 * @param int $minutes
		 */
		public function putMany(array $values, $minutes = 0): void
		{
			foreach ($values as $key => $data)
				$this->put($key, $data, $minutes);
		}

		/**
		 * Cache creation through serialization in json coding.
		 * If you want to cache response you pass the $data parameter as a Response instance
		 *
		 * @param string $key
		 * @param $data
		 * @param string $type
		 * @param int $minutes
		 * @return mixed
		 */
		public function put(string $key, $data, $minutes = 0): void
		{
			$serialize = $this->serialize($data);
			$this->file->{$minutes ? 'put' : 'forever'}($key, $serialize, $minutes);
		}

		/**
		 * Method for taking multiple keys together, returns a key associative array => value
		 *
		 * @param array $keys
		 * @return mixed
		 */
		public function getMany(array $keys)
		{
			foreach ($keys as $key)
				$response[$key] = $this->get($key);
			return $response;
		}

		/**
		 * Method to recover the cache from file or redis
		 *
		 * @param $key
		 * @param string $type
		 * @return $this|string|BinaryFileResponse
		 */
		public function get($key)
		{
			$data = $this->file->get($key);
			return $this->unserialize($data);
		}

		/**
		 * Delete file cache with array key
		 * @param array $keys
		 */
		public function forgetMany(array $keys): void
		{
			foreach ($keys as $key)
				$this->forget($key);
		}

		/**
		 * Delete file cache with key
		 * @param string $key
		 * @return bool
		 */
		public function forget(string $key): bool
		{
			return $this->file->forget($key);
		}

		/**
		 * Delete all file cache
		 */
		public function clear()
		{
			$this->file->flush();
		}

		/**
		 * Return object file (CacheManager)
		 */
		public function file()
		{
			return $this->file;
		}
	}