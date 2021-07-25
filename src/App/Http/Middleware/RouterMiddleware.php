<?php

namespace App\Http\Middleware;

use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouterMiddleware implements MiddlewareInterface
{
    private MiddlewareResolver $resolver;
    private Router $router;

    public function __construct(Router $router, MiddlewareResolver $resolver)
    {
        $this->router = $router;
        $this->resolver = $resolver;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $result = $this->router->match($request);
        foreach ($result->getAttributes() as $attribute => $value) {
            $request = $request->withAttribute($attribute, $value);
        }

        $middleware = $this->resolver->resolve($result->getHandler());
        return $middleware->process($request, $handler);
    }
}
