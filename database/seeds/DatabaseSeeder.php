<?php

	use Illuminate\Database\Seeder;

	class DatabaseSeeder extends Seeder
	{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			// Disable foreign key checking because truncate() will fail
			DB::statement('SET FOREIGN_KEY_CHECKS = 0');

			\App\Models\User::truncate();
			\App\Models\Post::truncate();

			factory(\App\Models\User::class, 10)->create();
			factory(\App\Models\Post::class, 30)->create();

			// Enable it back
			DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		}
	}
