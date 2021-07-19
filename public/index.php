<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\HomeAction;
use Framework\Http\ActionResolver;
use Framework\Http\Router\exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$actionResolver = new ActionResolver();
$request = ServerRequestFactory::fromGlobals();
$collection = new RouteCollection();

## Routes
$collection->any('home', '/', HomeAction::class);
$collection->any('about', '/about', AboutAction::class);
$collection->any('blog.show', '/blog/{id}', BlogShowAction::class, ['id' => '\d+']);

## Run
$router = new Router($collection);
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
