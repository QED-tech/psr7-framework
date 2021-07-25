<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Actions\NotFoundAction;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Pipelines\Pipeline;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// Initialization

$params = [
	'users' => ['admin' => 'password']
];

$middlewareResolver = new MiddlewareResolver();
$request = ServerRequestFactory::fromGlobals();

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

// Routes
$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('cabinet', '/cabinet', [
	ProfilerMiddleware::class,
	new AuthMiddleware($params['users']),
	CabinetAction::class
]);
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);

// Run
try {
	$result = $router->match($request);
	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}
	$action = $middlewareResolver->resolve($result->getHandler());
	$response = $action($request);
} catch (RequestNotMatchedException $e) {
	$action = new NotFoundAction();
	$response = $action($request);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
