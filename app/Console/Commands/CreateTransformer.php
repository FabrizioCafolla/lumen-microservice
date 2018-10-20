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

	class CreateTransformer extends Command
	{
		/**
		 * The console command name.
		 *
		 * @var string
		 */
		protected $signature = "create:transformer";

		/**
		 * The console command description.
		 *
		 * @var string
		 */
		protected $description = "Create transformer files";


		/**
		 * Execute the console command.
		 *
		 * @return mixed
		 */
		public function handle()
		{
			$post = null;

			$name = $this->ask('Name transformer?');

			$model = $this->ask('Only name of model to connect to transformer? (generic path App\Models)');

			$var = strtolower($model);

			$fileContents = <<<EOT
<?php

	namespace App\Transformers;

	use App\Models\\{$model};
	use App\Transformers\MasterTransformer;

	class {$name}Transformer extends MasterTransformer
	{
		protected \$availableIncludes = [];
		protected \$defaultIncludes = [];

		/**
		 * @Request {$model}
		 * @Response array
		 */
		public function transform({$model} \${$var})
		{
			return [];
		}
	}
EOT;

			$dir_location = 'app/Transformers/' . $name . 'Transformer.php';


			$file = Storage::disk('command')->put($dir_location, $fileContents);

			if ($file) {
				$this->info('Created new Transformer ' . $name . 'Transformer.php in App\Transformer.');
			} else {
				$this->info('Something went wrong');
			}
		}
	}