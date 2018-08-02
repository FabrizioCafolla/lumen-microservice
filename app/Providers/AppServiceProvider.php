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
			$this->app->singleton(
				\Illuminate\Contracts\Console\Kernel::class,
				\App\Console\Kernel::class
			);

			$this->app->singleton(
				\Illuminate\Contracts\Debug\ExceptionHandler::class,
				\App\Exceptions\Handler::class
			);

			$this->app->singleton('filesystem', function ($app) {
				return $app->loadComponent(
					'filesystems',
					\Illuminate\Filesystem\FilesystemServiceProvider::class,
					'filesystem'
				);
			});

			/*
			 * Service Api
			 */
			$this->app->bind(ApiService::class, function ($app) {
				return new ApiService($app);
			});
			$this->app->alias(ApiService::class, 'ApiService');

			/*
			 * Service Response
			 */
			$this->app->bind(ResponseService::class, function ($app) {
				return new ResponseService($app);
			});
			$this->app->alias(ResponseService::class, 'ResponseService');

			/*
			 * Service Helpers
			 */
			$this->app->bind(HelpersService::class, function () {
				return new HelpersService();
			});
			$this->app->alias(HelpersService::class, 'HelpersService');
		}
	}
