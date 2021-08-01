<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Middleware\AuthMiddleware;
use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
/** @var array $params */
$routes->get('cabinet', '/cabinet', [
	new AuthMiddleware($params['users']),
	CabinetAction::class
]);
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);