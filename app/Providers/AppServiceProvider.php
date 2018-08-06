<?php

	namespace App\Providers;

	use App\Services\HelpersService;
	use App\Services\ResponseService;
	use Illuminate\Support\ServiceProvider;
	use App\Services\ApiService;

	class AppServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			/*
			 * Service Api
			 */
			$this->app->bind(ApiService::class, function () {
				return new ApiService();
			});

			/*
			 * Service Response
			 */
			$this->app->bind(ResponseService::class, function () {
				return new ResponseService();
			});

			/*
			 * Service Helpers
			 */
			$this->app->bind(HelpersService::class, function () {
				return new HelpersService();
			});
		}
	}
