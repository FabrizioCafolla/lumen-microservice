<?php

	/*
	|--------------------------------------------------------------------------
	| Model Factories
	|--------------------------------------------------------------------------
	|
	| Here you may define all of your model factories. Model factories give
	| you a convenient way to create models for testing and seeding your
	| database. Just tell the factory how a default model should look.
	|
	*/


	$factory->define(\App\Models\Post::class, function (Faker\Generator $faker) {
		return [
			'user_id' => mt_rand(1, 10),
			'status' => '{"status":"active"}',
			'title' => $faker->sentence(5),
			'description' => $faker->paragraph(20)
		];
	});

	$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
		$hasher = app()->make('hash');
		return [
			'email' => $faker->email,
			'name' => $faker->name,
			'password' => $hasher->make("root"),
			'surname' => $faker->name
		];
	});
