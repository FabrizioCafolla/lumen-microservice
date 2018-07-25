<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['prefix' => 'admin'], function () use ($api) {
        $api->get('hello/{id}', function ($id) {
            return 'Hello World "' . $id .'"';
        });
    });

    $api->group(['prefix' => 'users'], function () use ($api) {
        $api->get('hello/{id}', 'App\Api\v1\TestApiController@show');
    });

});