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
			$this->typeContractsQL();
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
			GraphQL::addType('App\Api\GraphQL\Type\User\UserType', 'User');
			GraphQL::addType('App\Api\GraphQL\Type\User\UserWithPostType', 'UserWithPost');
			GraphQL::addType('App\Api\GraphQL\Type\User\UserPaginateType', 'UserPaginate');
			GraphQL::addType('App\Api\GraphQL\Type\PostType', 'Post');
		}

		/**
		 * Load Type of GraphQL without use config file
		 */
		protected function typeContractsQL() {
			GraphQL::addType('App\Api\GraphQL\Type\Contracts\PaginateType', 'pageInfo');
		}
	}
