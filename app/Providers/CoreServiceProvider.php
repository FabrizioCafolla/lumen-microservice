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
			$this->registerServices();
			$this->registerMiddleware();
			$this->registerProviders();
		}

		/**
		 * Register system providers Kernel/Console/Filesystem etc..
		 */
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

		/**
		 * Register Services
		 */
		protected function registerServices()
		{
			/**
			 * Service Response
			 */
			$this->app->singleton('service.response', 'App\Services\ResponseService');

			/**
			 * Service Api
			 */
			$this->app->singleton('service.api', 'App\Services\ApiService');

			/**
			 * Service Helpers
			 */
			$this->app->singleton('service.helpers', 'App\Services\HelpersService');

			/**
			 * Service ACL
			 */
			$this->app->singleton('service.acl', 'App\Services\ACLService');

			/**
			 * Service Log
			 */
			$this->app->singleton('service.log', 'App\Services\LogService');
		}

		/**
		 * Register middleware
		 */
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

		/**
		 * Register providers dependency
		 */
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
					'debug' => env('APP_DEBUG') ? ':debug' : env('APP_DEBUG')
				]
			]);
		}

		/**
		 * Load alias
		 */
		protected function setupAlias()
		{
			$aliases=[
				'Storage' => \Illuminate\Support\Facades\Storage::class,
				'ResponseService' => \App\Facades\ResponseFacade::class,
				'ApiService' => \App\Facades\ApiFacade::class,
				'HelpersService' => \App\Facades\HelpersFacade::class,
				'AclService' => \App\Facades\ACLFacade::class,
				'LogService' => \App\Facades\LogFacade::class
			];

			foreach ($aliases as $key => $value){
				class_alias($value, $key);
			}
		}

		/**
		 * Load config
		 */
		protected function setupConfig() {
			$this->app->configure('cache');
			$this->app->configure('database');
			$this->app->configure('filesystems');
			$this->app->configure('permission');
		}
	}
