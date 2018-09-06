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
			$this->app->bind('ResponseService', 'App\Services\ResponseService');

			/**
			 * Service Api
			 */
			$this->app->bind('ApiService', 'App\Services\ApiService');

			/**
			 * Service Helpers
			 */
			$this->app->bind('HelpersService', 'App\Services\HelpersService');

			/**
			 * Service ACL
			 */
			$this->app->bind('ACLService', 'App\Services\ACL\ACLService');

		}
	}
