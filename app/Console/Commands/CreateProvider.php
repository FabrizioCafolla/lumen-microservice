<?php
	/**
	 * Created by PhpStorm.
	 * User: fabrizio
	 * Date: 30/07/18
	 * Time: 14.53
	 */

	namespace App\Console\Commands;

	use Illuminate\Console\Command;
	use Illuminate\Http\File;
	use Illuminate\Support\Facades\Storage;

	class CreateProvider extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "create:provider";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create provider files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$name = $this->ask('Name provider?');

			$fileContents = <<<EOT
<?php

	namespace App\Providers;

	use Illuminate\Support\ServiceProvider;

	class {$name}ServiceProvider extends ServiceProvider
	{
		
		/**
		 * Boot the authentication services for the application.
		 *
		 */
		public function boot() {}
		
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			\$this->setupAlias();
			\$this->setupConfig();
			\$this->registerSystem();
			\$this->registerServices();
			\$this->registerMiddleware();
			\$this->registerProviders();
		}

		/**
		 * Register system providers Kernel/Console/Filesystem etc..
		 */
		protected function registerSystem() {}

		/**
		 * Register Services
		 */
		protected function registerServices() {}

		/**
		 * Register middleware
		 */
		protected function registerMiddleware()
		{
			//always when routes are called
			\$this->app->middleware([]);

			\$this->app->routeMiddleware([]);
		}

		/**
		 * Register providers dependency
		 */
		protected function registerProviders() {}

		/**
		 * Load alias
		 */
		protected function setupAlias() {
			\$aliases=[
				//
			];

			foreach (\$aliases as \$key => \$value){
				class_alias(\$value, \$key);
			}
		}

		/**
		 * Load config
		 */
		protected function setupConfig() {}
	}
EOT;

			$dir_location = 'Providers';


			$file_destination = $dir_location . '/' . $name . 'ServiceProvider.php';


			$file = Storage::disk('command')->put($file_destination, $fileContents);

			if ($file) {
				$this->info('Created new Provider ' . $name . 'ServiceProvider.php in App\Providers');
				$this->info('Add this in config/providers.php: ');
				$this->line('\'' . strtolower($name) . '\' => ' . '\\App\\Providers\\' . $name . 'ServiceProvider::class,');
			} else {
				$this->info('Something went wrong');
			}
		}

	}