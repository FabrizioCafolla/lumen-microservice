<?php

	namespace App\Http\Middleware;

	use ResponseService;
	use Closure;
	use AuthService;
	use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

	class OwnerMiddleware extends BaseMiddleware
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
			$idRequest = $request->id ?:null;
			$userLogged = AuthService::guard()->user();

			if($idRequest !== strval($userLogged->id))
				ResponseService::errorException('Unauthorized action.',405);

			return $next($request);
		}
	}
