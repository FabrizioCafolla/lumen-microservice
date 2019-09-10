<?php

	namespace App\Http\Middleware;

	use Closure;

	class CorsMiddleware
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure $next
		 *
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			$origin = $this->getOrigin($request);
			//If is internal request return response without CORS head
			if (!$origin && false === $this->isCorsRequest($origin, $request))
				return $next($request);

			//Get CORS headers from config file
			$cors_headers = get_config_env('api.cors', 'standard');

			//Return preflight response
			if (true === $this->isPreflightRequest($request))
				return response("OK", 200, $cors_headers);

			//Check if CORS 'Access-Control-Allow-Origin' request is valide
			if (true === $this->isValideOrigin($cors_headers, $origin, $request))
				$cors_headers['Access-Control-Allow-Origin'] = $origin;
			else
				return response("Unauthorized", 401);

			//Add CORS headers to response
			$response = $next($request);
			foreach ($cors_headers as $key => $value)
				$response->headers->set($key, $value);

			return $response;
		}

		/**
		 * Check if reqeust is a preflight request
		 *
		 * @param $request
		 *
		 * @return bool
		 *             true: is preflight request
		 */
		public function isPreflightRequest($request)
		{
			return $request->method() === 'OPTIONS' && $request->headers->has('Access-Control-Request-Method');
		}

		/**
		 * Check if request is a CORS request
		 * @param $request
		 *
		 * @return bool
		 *             true: is CORS request
		 */
		public function isCorsRequest($origin, $request): bool
		{
			$isSameHost = $origin === $request->getSchemeAndHttpHost();

			return $origin && !$isSameHost;
		}

		/**
		 * @param $request
		 * @return string|null
		 */
		public function getOrigin($request): ?string
		{
			return $request->headers->has('Origin') ? $request->headers->get('Origin') : null;
		}

		/**
		 * @param $cors_headers
		 * @param $origin
		 * @param $request
		 * @return bool
		 */
		public function isValideOrigin($cors_headers, $origin, $request): bool
		{
			if (!array_key_exists('Access-Control-Allow-Origin', $cors_headers))
				return true;
			if ('*' === $cors_headers['Access-Control-Allow-Origin'])
				return true;

			$valideRequest = false;

			$allowOrigins = explode(',', $cors_headers['Access-Control-Allow-Origin']);

			foreach ($allowOrigins as $allowOrigin)
				if ($origin === trim($allowOrigin))
					$valideRequest = true;
			return $valideRequest;
		}
	}