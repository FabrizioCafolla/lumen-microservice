<?php
	return [
		/*
		 * Load Type graphQL
		 */
		'model' => [
			'User' => App\Http\GraphQL\Type\User\UserType::class,
			'UserWithPost' => App\Http\GraphQL\Type\User\UserWithPostType::class,
			'UserPagination' => App\Http\GraphQL\Type\User\UserPaginationType::class,

			'Post' =>  App\Http\GraphQL\Type\Post\PostType::class,
			'PostWithUser' => App\Http\GraphQL\Type\Post\PostWithUserType::class,
			'PostPagination' =>  App\Http\GraphQL\Type\Post\PostPaginationType::class,
		],

		/*
		 * Load contracts type
		 */
		'contracts' => [
			'PaginationMeta' =>  App\Http\GraphQL\Type\Contracts\PaginationMetaType::class,
			'Timestamp' =>  App\Http\GraphQL\Type\Contracts\TimestampType::class,
		],
	];