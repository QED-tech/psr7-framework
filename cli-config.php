<?php

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Laminas\ServiceManager\ServiceManager;
use Symfony\Component\Console\Helper\HelperSet;

require __DIR__ . '/vendor/autoload.php';

/** @var ServiceManager $container */
$container = require __DIR__ . '/config/container.php';

return new HelperSet([
	'em' => new EntityManagerHelper(
		$container->get(EntityManagerInterface::class)
	)
]);