<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
	    $this->app->bind('service.auth', 'App\Services\AuthService');
    }

	/**
	 * Register middleware
	 */
	protected function registerMiddleware()
	{
		$this->app->routeMiddleware([
			'api.jwt' => \App\Http\Middleware\JwtMiddleware::class,
			'api.auth' => \App\Http\Middleware\AuthenticateMiddleware::class,
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
		$aliases=[
			'JWTAuth' => \Tymon\JWTAuth\Facades\JWTAuth::class,
			'JWTFactory' => \Tymon\JWTAuth\Facades\JWTFactory::class,
			'AuthService' => \App\Facades\AuthFacade::class
		];

		foreach ($aliases as $key => $value){
			class_alias($value, $key);
		}
	}

	/**
	 * Load config
	 */
	protected function setupConfig(){
		$this->app->configure('auth');
		$this->app->configure('jwt');
	}
}
