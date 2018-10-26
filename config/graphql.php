<?php


return [
    'prefix' => 'api/graph',

    'domain' => null,

    'routes' => '{graphql_schema?}',

    'controllers' => \Folklore\GraphQL\GraphQLController::class.'@query',

    'variables_input_name' => 'variables',

    'middleware' => ['api.jwt'],

    'middleware_schema' => [
        'default' => [],
    ],

    'headers' => [],

    'json_encoding_options' => 0,

    'graphiql' => [
        'routes' => '/api/graph/{graphql_schema?}',
        'controller' => \Folklore\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => ['api.jwt'],
        'view' => 'graphql::graphiql',
        'composer' => \Folklore\GraphQL\View\GraphiQLComposer::class,
    ],

    'schema' => env('API_STABLE_VERSION', 'default'),

    'schemas' => [
	    'default' => [
		    'query' => [],
		    'mutation' => []
	    ],
	    //Version Graph API
	    'v1' => [
		    'query' => [
			    'users' => App\Api\GraphQL\v1\Query\UsersQuery::class,
		    ],
		    'mutation' => [
			    'updateUserName' => App\Api\GraphQL\v1\Mutation\UpdateUserNameMutation::class,
		    ]
	    ]
    ],

    'resolvers' => [
        'default' => [
        ],
    ],

    'defaultFieldResolver' => null,

    'error_formatter' => [\Folklore\GraphQL\GraphQL::class, 'formatError'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false
    ]
];
