<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 10/08/18
	 * Time: 13.21
	 */

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class ACLServiceProvider extends ServiceProvider
	{
		/**
		* Register any application services.
		*
		* @return void
		*/
		public function register()
		{
			/**
			 * Service ACL
			 */
			$this->app->bind('ACLService', 'App\Services\ACL\ACLService');

			/**
			 * Service Admin ACL
			 */
			$this->app->bind('AdminACLService', 'App\Services\ACL\AdminACLService');
		}
	}