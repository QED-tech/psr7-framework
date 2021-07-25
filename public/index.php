<?php

use App\Http\Actions\AboutAction;
use App\Http\Actions\Blog\BlogShowAction;
use App\Http\Actions\CabinetAction;
use App\Http\Actions\HomeAction;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\ErrorsCatcherMiddleware;
use App\Http\Middleware\ProfilerMiddleware;
use App\Http\Middleware\RouterMiddleware;
use Aura\Router\RouterContainer;
use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\Stratigility\MiddlewarePipe;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// Initialization
$params = [
    'users' => ['admin' => 'password']
];

$request = ServerRequestFactory::fromGlobals();
$resolver = new MiddlewareResolver();
$app = new MiddlewarePipe();

$aura = new RouterContainer();
$routes = $aura->getMap();
$router = new AuraRouterAdapter($aura);

$app->pipe(new ProfilerMiddleware());
$app->pipe(new ErrorsCatcherMiddleware());
$app->pipe(new RouterMiddleware($router, $resolver));

// Routes
$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('cabinet', '/cabinet', [
    new AuthMiddleware($params['users']),
    CabinetAction::class
]);
$routes->get('blog.show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);


// Run
$response = $app->handle($request);

$emitter = new SapiEmitter();
$emitter->emit($response);
