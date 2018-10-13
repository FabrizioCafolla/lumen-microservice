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
			$this->setupAlias();
			$this->setupConfig();
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
			//always when routes are called
			$this->app->middleware([]);

			$this->app->routeMiddleware([]);
		}

		/**
		 * Register providers dependency
		 */
		protected function registerProviders() {}

		/**
		 * Load alias
		 */
		protected function setupAlias() {
			$aliases=[
				//
			];

			foreach ($aliases as $key => $value){
				class_alias($value, $key);
			}
		}

		/**
		 * Load config
		 */
		protected function setupConfig() {}
	}