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
    }
}
