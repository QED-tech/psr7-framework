<?php

namespace Framework\Http\Pipelines;

use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\MiddlewarePipe;
use function Laminas\Stratigility\middleware;

class MiddlewareResolver
{
    public function resolve(mixed $handler): mixed
    {
        return is_array($handler)
            ? $this->createPipe($handler)
            : $this->createHandler($handler);
    }

    private function createPipe(array $handlers): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->createHandler($handler));
        }
        return $pipeline;
    }

    private function createHandler(mixed $action)
    {
        return is_string($action) ? $this->createMiddleware($action) : $action;
    }

    private function createMiddleware(string $action): CallableMiddlewareDecorator
    {
        return middleware(function ($request) use ($action) {
            return (new $action())->handle($request);
        });
    }
}
