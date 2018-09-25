<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services\Cache\CacheRepository;

	use App\Services\Cache\CacheAbstract\CacheAbstract;
	use Illuminate\Http\Response;

	/**
	 * Class RedisService
	 * @package App\Services\Cache\CacheRepository
	 */
	class RedisService extends CacheAbstract {
		/**
		 * @var Redis
		 */
		private $redis;

		/**
		 * RedisService constructor.
		 */
		public function __construct()
		{
			$this->redis = app('redis');
		}

		/**
		 * Method for creating multiple items in the cache
		 * Example ['key' => $value, 'key2' => $value2]
		 *
		 * @param array $values
		 * @param int $minutes
		 */
		public function putMany(array $values, $minutes = 0) :void
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
		 * @param int $minutes
		 * @return mixed
		 */
		public function put(string $key, $data, $minutes = 0) :void
		{
			$serialize = $this->serialize($data);
			$this->redis->set($key, $serialize, $minutes);
		}

		/**
		 * Method for taking multiple keys together, returns an associative array
		 * Example ['key' => 'value']
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
		 * @return $this|string|Response
		 */
		public function get($key)
		{
			$data = $this->redis->get($key);
			return $this->unserialize($data);
		}

		/**
		 * Example use:
		 * forget('key2');     // return 1
		 * forget(['key3', 'key4']);   // return 2
		 *
		 * @param string $key
		 * @return bool
		 */
		public function forget($key): bool
		{
			return $this->redis->del($key);
		}

		/**
		 * Return object redis (Redis class)
		 */
		public function redis()
		{
			return $this->redis;
		}
	}