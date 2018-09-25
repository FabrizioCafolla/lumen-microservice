<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services;

	use App\Facades\ResponseFacade;
	use Carbon\Carbon;
	use \Illuminate\Http\Response;
	use Illuminate\Cache\CacheManager;
	use Illuminate\Support\Facades\Cache;

	class CacheService
	{
		const RESPONSE_TYPE = 'response_type_normal';

		/**Use method for storage cache in file
		 *
		 * @var CacheService
		 */
		public $file;
		/**
		 * @var Redis
		 */
		public $redis;

		/**
		 * CacheService constructor.
		 * @param CacheRepository $cache
		 * @return CacheRepository for instance in
		 */
		public function __construct(CacheManager $cache)
		{
			$this->file = $cache;
			$this->redis = app('redis');
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
		public function put(string $key, $data, string $type = 'file', $minutes = 0)
		{
			$serialize = $this->serialize($data);

			if ($type === 'redis')
				return $this->redis->set($key, $serialize, $minutes);

			return $this->file->{$minutes ? 'put' : 'forever'}($key, $serialize, $minutes);
		}

		/**
		 * Method for creating multiple items in the cache
		 * Example ['key' => $value, 'key2' => $value2]
		 *
		 * @param array $values
		 * @param $type
		 * @param int $minutes
		 */
		public function putMany(array $values, $type, $minutes = 0)
		{
			foreach ($values as $key => $data)
				$this->put($key, $data, $type, $minutes);
		}

		/**
		 * Private method for serialization, implements a control to correctly cache responses.
		 *
		 * @param $response
		 * @return string
		 */
		private function serialize($response): string
		{
			if (!($response instanceof Response))
				return json_encode($response);

			$headers = $response->headers;
			$status = $response->getStatusCode();
			$content = $response->getContent();
			$type = self::RESPONSE_TYPE;

			$responseSerialized = response(compact('content', 'type', 'status'))
				->withHeaders($headers);

			return json_encode($responseSerialized);
		}

		/**
		 * Method for taking multiple keys together, returns a key associative array => value
		 *
		 * @param array $values
		 * @param $type
		 */
		public function getMany(array $keys, $type)
		{
			foreach ($keys as $key)
				$response[$key] = $this->get($key, $type);
			return $response;
		}

		/**
		 * Method to recover the cache from file or redis
		 *
		 * @param $key
		 * @param string $type
		 * @return $this|string|BinaryFileResponse
		 */
		public function get($key, $type = 'file')
		{
			$data = $this->{$type}->get($key);
			return $this->unserialize($data);
		}

		/**
		 * Private method that decodes the data recovered from the cache, using json decode and if the cachet data is an response will be decoded correctly
		 *
		 * @param string $serializedResponse
		 * @return $this|string|BinaryFileResponse
		 */
		private function unserialize(string $serializedResponse)
		{
			$responseProperties = json_decode($serializedResponse, true);
			$type = $responseProperties['original']['type'] ?? false;
			if ($type !== self::RESPONSE_TYPE)
				return $responseProperties;

			$response = ResponseFacade::custom($responseProperties['original']['content'], $responseProperties['original']['status'], $responseProperties['headers']);

			return $response;
		}
	}