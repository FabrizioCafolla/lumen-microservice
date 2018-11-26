<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class AppServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->setupConfig();
			$this->registerAlias();
			$this->registerSystem();
			$this->registerServices();
			$this->registerMiddleware();
			$this->registerProviders();
		}

		/**
		 * Register system providers Kernel/Console/Filesystem etc..
		 */
		protected function registerSystem() {}

		/**
		 * Register Services
		 */
		protected function registerServices() {}

		/**
		 * Register middleware
		 */
		protected function registerMiddleware()
		{
			$middlewares = config('providers.middlewares') ?: [];
			foreach ($middlewares as $middleware) {
				$this->app->middleware([
					$middleware
				]);
			}

			$route_middlewares = config('providers.route_middlewares') ?: [];
			foreach ($route_middlewares as $key => $value) {
				$this->app->routeMiddleware([
					$key => $value
				]);
			}
		}

		/**
		 * Register providers dependency
		 */
		protected function registerProviders() {}

		/**
		 * Load alias
		 */
		protected function registerAlias()
		{
			$aliases = config('providers.alias') ?: [];
			foreach ($aliases as $key => $value) {
				class_alias($value, $key);
			}
		}

		/**
		 * Load config
		 */
		protected function setupConfig() {}
	}