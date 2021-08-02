<?php

use Framework\Application;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\ServiceManager\ServiceManager;

require __DIR__ . '/../vendor/autoload.php';

/** @var ServiceManager $container */
$container = require __DIR__ . '/../config/container.php';
/** @var Application $app */
$app = $container->get(Application::class);

(require __DIR__ . '/../config/routes.php')($container);
(require __DIR__ . '/../config/pipeline.php')($app);

$response = $app->run(
    ServerRequestFactory::fromGlobals()
);

$emitter = new SapiEmitter();
$emitter->emit($response);
