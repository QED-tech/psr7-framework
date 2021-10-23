<?php

use Doctrine\ORM\EntityManagerInterface;
use Laminas\ServiceManager\ServiceManager;

require __DIR__ . '/vendor/autoload.php';

/** @var ServiceManager $container */
$container = require __DIR__ . '/config/container.php';

return new \Symfony\Component\Console\Helper\HelperSet([
	'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
		$container->get(EntityManagerInterface::class)
	)
]);