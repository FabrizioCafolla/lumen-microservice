<?php
	return [
		'credentials' => [
			'key' => env('AWS_ACCESS_KEY_ID', ''),
			'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
		],
		'region' => env('AWS_REGION', 'us-east-1'),
		'version' => 'latest',
	];