<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 31/07/18
	 * Time: 16.30
	 */

	namespace App\Services\Cache\CacheAbstract;

	use App\Facades\ResponseFacade;
	use \Illuminate\Http\Response;

	/**
	 * Class CacheAbstract
	 * @package App\Services\Cache\CacheAbstract
	 */
	class CacheAbstract
	{
		const RESPONSE_TYPE = 'response_type_normal';

		/**
		 * Private method for serialization, implements a control to correctly cache responses.
		 *
		 * @param $response
		 * @return string
		 */
		protected function serialize($response): string
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
		 * Private method that decodes the data recovered from the cache, using json decode and if the cachet data is an response will be decoded correctly
		 *
		 * @param string $serializedResponse
		 * @return $this|string|Response
		 */
		protected function unserialize(string $serializedResponse)
		{
			$responseProperties = json_decode($serializedResponse, true);
			$type = $responseProperties['original']['type'] ?? false;
			if ($type !== self::RESPONSE_TYPE)
				return $responseProperties;

			$response = ResponseFacade::custom($responseProperties['original']['content'], $responseProperties['original']['status'], $responseProperties['headers']);

			return $response;
		}
	}