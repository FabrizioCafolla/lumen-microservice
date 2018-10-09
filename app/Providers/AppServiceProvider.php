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
			$this->registerServiceApp();
			$this->registerClassAliases();
			$this->registerConfigure();
		}

		protected function registerServiceApp()
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

		protected function registerConfigure(){
			$this->app->configure('cache');
			$this->app->configure('database');
			$this->app->configure('filesystems');
			$this->app->configure('auth');
			$this->app->configure('jwt');
			$this->app->configure('permission');
		}
		protected function registerClassAliases()
		{
			class_alias(\Illuminate\Support\Facades\Storage::class, 'Storage');
			class_alias(\App\Facades\ResponseFacade::class, 'ResponseService');
			class_alias(\App\Facades\ApiFacade::class, 'ApiService');
			class_alias(\App\Facades\HelpersFacade::class, 'HelpersService');
			class_alias(\App\Facades\AuthFacade::class, 'AuthService');
			class_alias(\App\Facades\ACLFacade::class, 'AclService');
			class_alias(\App\Facades\LogFacade::class, 'LogService');
		}
	}
