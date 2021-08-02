<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Middleware\AuthMiddleware;
use Aura\Router\Map;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface;

return static function (ContainerInterface $container) {
	/** @var AuraRouterAdapter $router */
	$router = $container->get(Router::class);
	$routes = $router->getAura()->getMap();
	
	$routes->get('home', '/', HomeAction::class);
	$routes->get('about', '/about', AboutAction::class);
	$routes->get('cabinet', '/cabinet', [
		AuthMiddleware::class,
		CabinetAction::class
	]);
	$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);
};