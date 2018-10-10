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

	class CreateRepositroy extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "create:repository";

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

			$name = $this->ask('Name repository?');
			$path = $this->anticipate('Path model to connect at repository?', ["App\Models\\", "app\Models\\"]);

			$fileContents = <<<EOT
<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Contracts\RepositoryAbstract;
use Illuminate\Support\Facades\Validator;


class {$name}Repository extends RepositoryAbstract implements RepositoryInterface
{
	protected \$rules = [];

	/**
	 * Specify Model class name
	 *
	 * @return mixed
	 */
	function model()
	{
		return "{$path}";
	}
}
EOT;

			$dir_location = 'app/Repositories/' . $name . 'Repository.php';

			$file = Storage::disk('command')->put($dir_location, $fileContents);

			if($file) {
				$this->info('Created new Repo '.$name.'Repository.php in App\Repositories.');
			} else {
				$this->info('Something went wrong');
			}
		}
	}