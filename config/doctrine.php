<?php

use Doctrine\DBAL\Driver\PDO\SQLite\Driver;
use Doctrine\Persistence\Mapping\Driver\MappingDriverChain;
use Infrastructure\PDOFactory;

return [
	'doctrine' => [
		'connection' => [
			'orm_default' => [
				'pdo' => PDOFactory::class,
				'driver_class' => Driver::class
			]
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