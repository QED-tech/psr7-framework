<?php

use Framework\Application;
use Framework\Http\Pipelines\MiddlewareResolver;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// Initialization
$params = require 'config/config.php';
$container = require 'config/container.php';

$request = ServerRequestFactory::fromGlobals();
$resolver = new MiddlewareResolver($container);

$app = new Application($resolver);

require 'config/routes.php';
require 'config/pipeline.php';

// Run
$response = $app->run($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
