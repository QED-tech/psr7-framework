<?php

use App\Http\Middleware\ErrorsCatcherMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouterMiddleware;
use Framework\Application;

return static function (Application $app) {
	$app->pipe(ProfilerMiddleware::class);
	$app->pipe(ErrorsCatcherMiddleware::class);
	$app->pipe(RouterMiddleware::class);
};