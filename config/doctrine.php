<?php

return [
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'pdo' => PDO::class,
				'driver_class' => \Doctrine\DBAL\Driver\PDO\SQLite\Driver::class
			]
		],
		'driver' => [
			'orm_default' => [
				'class' => \Doctrine\Persistence\Mapping\Driver\MappingDriverChain::class,
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