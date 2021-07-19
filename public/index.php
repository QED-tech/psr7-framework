<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\HomeAction;
use Framework\Http\Router\exception\RequestNotMatchedException;
use Framework\Http\Router\RouteCollection;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Initialization
$request = ServerRequestFactory::fromGlobals();
$collection = new RouteCollection();

## Routes
$collection->any('home', '/', new HomeAction());
$collection->any('about', '/about', new AboutAction());
$collection->any('blog.show', '/blog/{id}', new BlogShowAction(), ['id' => '\d+']);

## Run
$router = new Router($collection);
try {
	$result = $router->match($request);
	$action = $result->getHandler();
	foreach ($result->getAttributes() as $attribute => $value) {
		$request = $request->withAttribute($attribute, $value);
	}
	
	/** @var callable $action */
	$response = $action($request);
} catch (RequestNotMatchedException $e) {
	$response = new Response\JsonResponse(['error' => $e->getMessage()]);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
