<?php

	namespace App\Providers;

	use GraphQL;
	use Illuminate\Support\ServiceProvider;

	class GraphQLServiceProvider extends ServiceProvider
	{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			$this->setupConfig();
			$this->registerProviders();
			$this->typeQL();
		}

		/**
		 * Register providers dependency
		 */
		protected function registerProviders(){

			$this->app->register(\Folklore\GraphQL\LumenServiceProvider::class);
		}

		/**
		 * Load config
		 */
		protected function setupConfig() {
			$this->app->configure('graphql');
		}

		/**
		 * Load Type of GraphQL without use config file
		 */
		protected function typeQL() {
			GraphQL::addType('App\Api\GraphQL\v1\Type\UserType', 'User');
			GraphQL::addType('App\Api\GraphQL\v1\Type\PostType', 'Post');
		}
	}
