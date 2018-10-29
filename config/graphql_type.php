<?php
	return [
		/*
		 * Load Type graphQL
		 */
		'model' => [
			'User' => App\Api\GraphQL\Type\User\UserType::class,
			'UserWithPost' => App\Api\GraphQL\Type\User\UserWithPostType::class,
			'UserPagination' => App\Api\GraphQL\Type\User\UserPaginationType::class,

			'Post' =>  App\Api\GraphQL\Type\Post\PostType::class,
		],

		/*
		 * Load contracts type
		 */
		'contracts' => [
			'PaginationMeta' =>  App\Api\GraphQL\Type\Contracts\PaginationMetaType::class,
		],
	];