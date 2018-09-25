<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class CacheServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->app->bind('CacheService', 'App\Services\Cache\CacheService');
		}
	}
