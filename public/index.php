<?php

use Aura\Router\RouterContainer;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// Initialization
$params = require 'config/params.php';

$request = ServerRequestFactory::fromGlobals();
$resolver = new MiddlewareResolver();
$app = new MiddlewarePipe();

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

require 'config/pipeline.php';
require 'config/routes.php';

// Run
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
