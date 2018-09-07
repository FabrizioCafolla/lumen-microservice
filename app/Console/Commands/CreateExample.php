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

	class CreateExample extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "create:example";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create repository files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$this->createModels();
			$this->createRepository();
			$this->createTransformers();
			$this->createController();
			$this->createMigrationsAndSeed();
		}

		private function createModels()
		{
			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/User.php', '/Models/User.php');
			if ($file) {
				$this->info('Created User Models/');
			} else {
				$this->error('Something went wrong (User)');
			}

			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/Post.php', '/Models/Post.php');
			if ($file) {
				$this->info('Created Post Models/');
			} else {
				$this->error('Something went wrong (Post)');
			}
		}

		private function createRepository()
		{
			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/UserRepository.php', '/Repositories/UserRepository.php');
			if ($file) {
				$this->info('Created UserRepository Repositories/');
			} else {
				$this->error('Something went wrong (UserRepository)');
			}

			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/PostRepository.php', '/Repositories/PostRepository.php');
			if ($file) {
				$this->info('Created PostRepository Repositories/');
			} else {
				$this->error('Something went wrong (PostRepository)');
			}
		}

		private function createTransformers()
		{
			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/UserTransformer.php', '/Transformers/UserTransformer.php');
			if ($file) {
				$this->info('Created UserTransformer Transformers/');
			} else {
				$this->error('Something went wrong (UserTransformer)');
			}

			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/PostTransformer.php', '/Transformers/PostTransformer.php');
			if ($file) {
				$this->info('Created PostTransformer Transformers/');
			} else {
				$this->error('Something went wrong (PostTransformer)');
			}
		}

		private function createController()
		{
			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/UserController.php', '/Api/v1/UserController.php');
			if ($file) {
				$this->info('Created UserController App/Api/v1');
			} else {
				$this->error('Something went wrong (UserController)');
			}

			$file = Storage::disk('file')->copy('/Console/Commands/FileExample/PostController.php', '/Api/v1/PostController.php');
			if ($file) {
				$this->info('Created PostController App/Api/v1');
			} else {
				$this->error('Something went wrong (PostController)');
			}
		}

		private function createMigrationsAndSeed()
		{
			$file = Storage::disk('root')->copy('/app/Console/Commands/FileExample/2018_07_25_143539_users.php', '/database/migrations/2018_07_25_143539_users.php');
			if ($file) {
				$this->info('Created User migrations');
			} else {
				$this->error('Something went wrong (User)');
			}

			$file = Storage::disk('root')->copy('app/Console/Commands/FileExample/2018_07_25_192425_posts.php', '/database/migrations/2018_07_25_192425_posts.php');
			if ($file) {
				$this->info('Created Post migrations');
			} else {
				$this->error('Something went wrong (Post)');
			}

			Storage::disk('root')->delete('/database/factories/ModelFactory.php');
			Storage::disk('root')->delete('/database/seeds/DatabaseSeeder.php');

			$file = Storage::disk('root')->copy('app/Console/Commands/FileExample/ModelFactory.php', '/database/factories/ModelFactory.php');
			if ($file) {
				$this->info('Created ModelFactory');
			} else {
				$this->error('Something went wrong (factory)');
			}
			$file = Storage::disk('root')->copy('app/Console/Commands/FileExample/DatabaseSeeder.php', '/database/seeds/DatabaseSeeder.php');
			if ($file) {
				$this->info('Created seeds');
			} else {
				$this->error('Something went wrong (Seeds)');
			}
		}

	}