<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\JWTAuth;
use Dingo\Api\Auth\Auth as DingoAuth;
use Dingo\Api\Auth\Provider\JWT as JWTProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Boot the authentication services for the application.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->extend('api.auth', function (DingoAuth $auth) {
			$auth->extend('jwt', function ($app) {
				return new JWTProvider($app[JWTAuth::class]);
			});
			return $auth;
		});
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	    $this->setupAlias();
	    $this->setupConfig();
	    $this->registerMiddleware();
	    $this->registerServices();
	    $this->registerProviders();
    }

	/**
	 * Register Services
	 */
    protected function registerServices(){
	    /**
	     * Service User Auth
	     */
	    $this->app->bind('AuthService', 'App\Services\AuthService');
    }

	/**
	 * Register middleware
	 */
	protected function registerMiddleware()
	{
		$this->app->routeMiddleware([
			'api.jwt' => \App\Http\Middleware\JwtMiddleware::class,
		]);
	}

	/**
	 * Register providers dependency
	 */
	protected function registerProviders(){
		$this->app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);
	}

	/**
	 * Load alias
	 */
	protected function setupAlias() {
		class_alias(\Tymon\JWTAuth\Facades\JWTAuth::class, 'JWTAuth');
		class_alias(\Tymon\JWTAuth\Facades\JWTFactory::class, 'JWTFactory');
	}

	/**
	 * Load config
	 */
	protected function setupConfig(){
		$this->app->configure('auth');
		$this->app->configure('jwt');
	}
}
