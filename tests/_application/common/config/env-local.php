<?php

$envLocal = @include(ROOT_DIR . '/common/config/env-local.php');
$testConnection = !empty($envLocal['servers']['db']['test']) ? $envLocal['servers']['db']['test'] : [];

return [
	'project' => 'test',
	'mode' => [
		'debug' => true,
		'env' => 'dev',
	],
	'url' => [
		'frontend' => 'http://example.com/',
		'backend' => 'http://admin.example.com/',
		'api' => 'http://api.example.com/',
	],
	'cookieValidationKey' => [
		'frontend' => 'bBXEWnH5ERCG7SF3wxtbotYxq3W-Op7B',
		'backend' => 'zbfqVR5PhdO3E8Xi7DB4aoxmxSstJ6aI',
	],
	'domain' => [
		'driver' => [
			'primary' => 'disc',
			'slave' => 'ar',
		],
	],
	'servers' => [
		'db' => [
			'main' => [
				'driver' => 'mysql',
				'host' => 'localhost',
				'username' => 'root',
				'password' => '',
				'dbname' => 'example',
			],
			'test' => $testConnection,
		],
	],
];
