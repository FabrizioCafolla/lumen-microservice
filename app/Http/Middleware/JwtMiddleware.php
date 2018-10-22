<?php

	namespace App\Http\Middleware;

	use Closure;
	use AuthService;
	use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

	class JwtMiddleware extends BaseMiddleware
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param  \Illuminate\Http\Request $request
		 * @param  \Closure $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			AuthService::tryAuthenticatedUser();

			return $next($request);
		}
	}
