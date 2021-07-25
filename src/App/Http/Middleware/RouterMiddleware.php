<?php

namespace App\Http\Middleware;

use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\Router;
use Psr\Http\Message\ServerRequestInterface;

class RouterMiddleware
{
    private MiddlewareResolver $resolver;
    private Router $router;

    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        $result = $this->router->match($request);
        foreach ($result->getAttributes() as $attribute => $value) {
            $request = $request->withAttribute($attribute, $value);
        }
        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware($request, $next);
    }
}
