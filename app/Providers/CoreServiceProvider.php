<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class CoreServiceProvider extends ServiceProvider
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
			$this->registerService();
			$this->registerMiddleware();
			$this->registerProviders();
		}

		protected function registerSystem()
		{
			$this->app->singleton('filesystem', function ($app) {
				return $app->loadComponent(
					'filesystems',
					\Illuminate\Filesystem\FilesystemServiceProvider::class,
					'filesystem'
				);
			});

			$this->app->singleton(
				\Illuminate\Contracts\Console\Kernel::class,
				\App\Console\Kernel::class
			);

			$this->app->singleton(
				\Illuminate\Contracts\Debug\ExceptionHandler::class,
				\App\Exceptions\Handler::class
			);
		}

		protected function registerService()
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

		protected function registerMiddleware()
		{
			//call in all route for cors request
			$this->app->middleware([
				\App\Http\Middleware\CorsMiddleware::class
			]);

			$this->app->routeMiddleware([
				'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
				'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
			]);
		}

		protected function registerProviders(){
			$this->app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);

			$this->app->register(\LumenCacheService\CacheServiceProvider::class);

			$this->app->register(\Spatie\Permission\PermissionServiceProvider::class);

			$this->app->register(\Aws\Laravel\AwsServiceProvider::class);

			$this->app->register(\Dingo\Api\Provider\LumenServiceProvider::class);
			$this->app['Dingo\Api\Exception\Handler']->setErrorFormat([
				'error' => [
					'message' => ':message',
					'errors' => ':errors',
					'code' => ':code',
					'status_code' => ':status_code',
					'debug' => ':debug'
				]
			]);
		}

		protected function setupAlias()
		{
			class_alias(\Illuminate\Support\Facades\Storage::class, 'Storage');
			class_alias(\App\Facades\ResponseFacade::class, 'ResponseService');
			class_alias(\App\Facades\ApiFacade::class, 'ApiService');
			class_alias(\App\Facades\HelpersFacade::class, 'HelpersService');
			class_alias(\App\Facades\ACLFacade::class, 'AclService');
			class_alias(\App\Facades\LogFacade::class, 'LogService');
		}

		protected function setupConfig() {
			$this->app->configure('cache');
			$this->app->configure('database');
			$this->app->configure('filesystems');
			$this->app->configure('permission');
		}
	}
