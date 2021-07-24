<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\exception\RequestNotMatchedException;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization

$users = [
	'users' => ['admin' => 'password']
];

$actionResolver = new ActionResolver();
$request = ServerRequestFactory::fromGlobals();

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

## Routes
$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('cabinet', '/cabinet', new CabinetAction($users['users']));
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)
	->tokens(['id' => '\d+']);

## Run
try {
	$result = $router->match($request);
	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}
	
	$action = $actionResolver->resolve($result->getHandler());
	$response = $action($request);
} catch (RequestNotMatchedException $e) {
	$response = new Response\JsonResponse(['error' => $e->getMessage()]);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
