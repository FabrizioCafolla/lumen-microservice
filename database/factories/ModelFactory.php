<?php

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
