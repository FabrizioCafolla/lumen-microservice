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

			//load alias TypeRegistry
			class_alias(\App\Http\GraphQL\Type\Contracts\TypeRegistry::class, 'TypeRegistry');
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
			$this->app->configure('graphql_type');
		}

		/**
		 * Load Type of GraphQL without use config file
		 */
		protected function typeQL() {
			$models = config('graphql_type.model');
			foreach ($models as $key => $model){
				GraphQL::addType($model,$key);
			}
		}

		/**
		 * Load Type of GraphQL without use config file
		 */
		protected function typeContractsQL() {
			$contracts = config('graphql_type.contracts');
			foreach ($contracts as $key => $contract){
				GraphQL::addType($contract,$key);
			}
		}
	}
