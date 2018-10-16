<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 02/08/18
	 * Time: 11.48
	 */

	namespace App\Services;

	use Dingo\Api\Dispatcher;
	use Dingo\Api\Http\Response\Factory;

	class HelpersService
	{
		/**
		 * Get the internal dispatcher instance.
		 *
		 * @return \Dingo\Api\Dispatcher
		 */
		public function dispatcher()
		{
			return app(Dispatcher::class);
		}

		/**
		 * Get the response factory instance.
		 *
		 * @return \Dingo\Api\Http\Response\Factory
		 */
		public function factory()
		{
			return app(Factory::class);
		}

		// Add your methods to helps controllers
	}