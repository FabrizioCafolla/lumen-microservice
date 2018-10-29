<?php
	return [
		/*
		 * Load Type graphQL
		 */
		'model' => [
			'User' => App\Api\GraphQL\Type\User\UserType::class,
			'UserWithPost' => App\Api\GraphQL\Type\User\UserWithPostType::class,
			'UserPaginate' => App\Api\GraphQL\Type\User\UserPaginateType::class,

			'Post' =>  App\Api\GraphQL\Type\Post\PostType::class,
		],

		/*
		 * Load contracts type
		 */
		'contracts' => [
			'pageInfo' =>  App\Api\GraphQL\Type\Contracts\PaginateType::class,
		],
	];