<?php

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\ServiceManager;

$container = new ServiceManager([
	'abstract_factories' => [
		ReflectionBasedAbstractFactory::class
	]
]);

$config = require 'config/config.php';
$container->setService('config', $config);

return $container;