<?php

use App\Http\Middleware\ErrorsCatcherMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouterMiddleware;
use Framework\Application;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\Router;

/** @var Application $app */
$app->pipe(ProfilerMiddleware::class);
$app->pipe(ErrorsCatcherMiddleware::class);

/** @var Router $router */
/** @var MiddlewareResolver $resolver */

$app->pipe(new RouterMiddleware($router, $resolver));