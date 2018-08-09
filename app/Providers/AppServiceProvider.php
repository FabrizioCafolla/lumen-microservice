<?php

	namespace App\Providers;

	use ApiService;
	use HelpersService;
	use ResponseService;
	use ACLService;
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
			 * Service Api
			 */
			$this->app->bind(ApiService::class, function () {
				return new ApiService();
			});

			/**
			 * Service Response
			 */
			$this->app->bind(ResponseService::class, function () {
				return new ResponseService();
			});

			/**
			 * Service Helpers
			 */
			$this->app->bind(HelpersService::class, function () {
				return new HelpersService();
			});

			/**
			 * Service Permission
			 */
			$this->app->bind(ACLService::class, function () {
				return new ACLService();
			});
		}
	}
