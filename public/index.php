<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\ActionResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\exception\RequestNotMatchedException;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// Initialization

$params = [
    'users' => ['admin' => 'pass']
];

$actionResolver = new ActionResolver();
$request = ServerRequestFactory::fromGlobals();

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

// Routes
$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('cabinet', '/cabinet', function (ServerRequest $request) use ($params) {
    $auth = new AuthMiddleware($params['users']);
    $profiler = new ProfilerMiddleware();
    $cabinet = new CabinetAction();
    
    return $profiler($request, function (ServerRequest $request) use ($cabinet, $auth) {
        return $auth($request, function (ServerRequest $request) use ($cabinet) {
            return $cabinet($request);
        });
    });
});
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);

// Run
try {
    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $action = $actionResolver->resolve($result->getHandler());
    $response = $action($request);
} catch (RequestNotMatchedException $e) {
    $response = new JsonResponse(['error' => $e->getMessage()]);
}

$emitter = new SapiEmitter();
$emitter->emit($response);
