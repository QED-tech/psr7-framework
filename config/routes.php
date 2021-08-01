<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Middleware\AuthMiddleware;
use Aura\Router\Map;

/** @var Map $routes */
$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
/** @var array $params */
$routes->get('cabinet', '/cabinet', [
	new AuthMiddleware($params['users']),
	CabinetAction::class
]);
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);