<?php
/**
 * Created by PhpStorm.
 * User: fabrizio
 * Date: 29/11/18
 * Time: 23.59
 */

namespace App\Http\Controller;

use Laravel\Lumen\Routing\Controller as BaseController;

class RestController extends BaseController
{
	/**
	 * @var \Kosmosx\Support\Api\ApiService
	 */
	public $api;

	/**
	 * @var \Kosmosx\Auth\AuthService
	 */
	public $auth;

	/**
	 * @var \Kosmosx\Cache\Services\CacheFactory
	 */
	public $cache;

	/**
	 * @var \Kosmosx\Response\Factory\FactoryResponse
	 */
	public $response;

	public function __construct() {
		$this->auth = $this->resolve('service.auth');
		$this->api = $this->resolve('service.api');
		$this->cache = $this->resolve('factory.cache');
		$this->response = $this->resolve('factory.response');
	}

	/**
	 * Resolve instance
	 *
	 * @param string $class
	 * @param array $parameters
	 * @return \Laravel\Lumen\Application|mixed|null
	 */
    private function resolve(string $class, array $parameters = []) {
    	try {
    		return app($class,$parameters);
		} catch (\Exception $e){
			return null; //@TODO return null object
		}
	}
}