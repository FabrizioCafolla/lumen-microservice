<?php

	require_once __DIR__ . '/../vendor/autoload.php';

	try {
		(new Dotenv\Dotenv(__DIR__ . '/../'))->load();
	} catch (Dotenv\Exception\InvalidPathException $e) {
		//
	}


	/*
	|--------------------------------------------------------------------------
	| Create The Application
	|--------------------------------------------------------------------------
	|
	| Here we will load the environment and create the application instance
	| that serves as the central piece of this framework. We'll use this
	| application as an "IoC" container and router for this framework.
	|
	*/

	$app = new Laravel\Lumen\Application(
		realpath(__DIR__ . '/../')
	);

	$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
	$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');

	$app->withFacades();
	$app->withEloquent();

	/*
	|--------------------------------------------------------------------------
	| Register Container Bindings
	|--------------------------------------------------------------------------
	|
	| Now we will register a few bindings in the service container. We will
	| register the exception handler and the console kernel. You may add
	| your own bindings here if you like or you can make another file.
	|
	*/

	$app->singleton('filesystem', function ($app) {
		return $app->loadComponent(
			'filesystems',
			Illuminate\Filesystem\FilesystemServiceProvider::class,
			'filesystem'
		);
	});

	$app->singleton(
		\Illuminate\Contracts\Console\Kernel::class,
		\App\Console\Kernel::class
	);

	$app->singleton(
		\Illuminate\Contracts\Debug\ExceptionHandler::class,
		\App\Exceptions\Handler::class
	);

	/*
	|--------------------------------------------------------------------------
	| Register Middleware
	|--------------------------------------------------------------------------
	|
	| Next, we will register the middleware with the application. These can
	| be global middleware that run before and after each request into a
	| route or middleware that'll be assigned to some specific routes.
	|
	*/

	//call in all route for cors request
	$app->middleware([
		App\Http\Middleware\CorsMiddleware::class
	]);

	$app->routeMiddleware([
		'api.jwt' => App\Http\Middleware\JwtMiddleware::class,
		'permission' => Spatie\Permission\Middlewares\PermissionMiddleware::class,
		'role' => Spatie\Permission\Middlewares\RoleMiddleware::class,
	]);

	/*
	|--------------------------------------------------------------------------
	| Register Service Providers
	|--------------------------------------------------------------------------
	|
	| Here we will register all of the application's service providers which
	| are used to bind services into the container. Service providers are
	| totally optional, so you are not required to uncomment this line.
	|
	*/
	// $app->register(App\Providers\EventServiceProvider::class);

	$app->register(App\Providers\AppServiceProvider::class);

	$app->register(App\Providers\AuthServiceProvider::class);

	$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

	$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);

	$app->register(LumenCacheService\CacheServiceProvider::class);

	$app->register(Spatie\Permission\PermissionServiceProvider::class);

	$app->register(Aws\Laravel\AwsServiceProvider::class);

	$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
	$app['Dingo\Api\Exception\Handler']->setErrorFormat([
		'error' => [
			'message' => ':message',
			'errors' => ':errors',
			'code' => ':code',
			'status_code' => ':status_code',
			'debug' => ':debug'
		]
	]);

	/*
	|--------------------------------------------------------------------------
	| Load The Application Routes
	|--------------------------------------------------------------------------
	|
	| Next we will include the routes file so that they can all be added to
	| the application. This will provide all of the URLs the application
	| can respond to, as well as the controllers that may handle them.
	|
	*/

	$app->router->group([
		'namespace' => 'App\Http\Controllers',
	], function ($router) {
		require __DIR__ . '/../routes/web.php';
	});

	return $app;
