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
			/**
			 * Service Response
			 */
			$this->app->singleton('ResponseService', 'App\Services\ResponseService');

			/**
			 * Service Api
			 */
			$this->app->singleton('ApiService', 'App\Services\ApiService');

			/**
			 * Service Helpers
			 */
			$this->app->singleton('HelpersService', 'App\Services\HelpersService');

			/**
			 * Service ACL
			 */
			$this->app->singleton('ACLService', 'App\Services\ACLService');

			/**
			 * Service Log
			 */
			$this->app->singleton('LogService', 'App\Services\LogService');

		}
	}
