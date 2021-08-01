<?php

use App\Http\Middleware\ErrorsCatcherMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouterMiddleware;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Stratigility\MiddlewarePipe;

/** @var MiddlewarePipe $app */
$app->pipe(new ProfilerMiddleware());
$app->pipe(new ErrorsCatcherMiddleware());
/** @var Router $router */
/** @var MiddlewareResolver $resolver */
$app->pipe(new RouterMiddleware($router, $resolver));