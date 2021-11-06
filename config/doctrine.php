<?php

use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;

return [
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'pdo' => PDO::class,
				'driver_class' => Doctrine\DBAL\Driver\PDO\SQLite\Driver::class
			]
		],
		'configuration' => [
			'orm_default' => [
				'result_cache' => 'filesystem',
				'metadata_cache' => 'filesystem',
				'query_cache' => 'filesystem',
				'hydration_cache' => 'filesystem',
			],
		],
		'driver' => [
			'orm_default' => [
				'class' => MappingDriverChain::class,
				'drivers' => [
					'App\Entity' => 'entities',
				],
			],
			'entities' => [
				'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
				'cache' => 'filesystem',
				'paths' => ['src/App/Entity'],
			],
		],
	]
];