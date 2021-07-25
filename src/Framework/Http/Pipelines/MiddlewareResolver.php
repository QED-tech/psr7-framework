<?php

namespace Framework\Http\Pipelines;

use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\MiddlewarePipe;
use function Laminas\Stratigility\middleware;

class MiddlewareResolver
{
    public function resolve(mixed $handler): mixed
    {
        if (is_array($handler)) {
            return $this->createPipe($handler);
        }

        if (is_string($handler)) {
            return $this->createHandler($handler);
        }

        return $handler;
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

    private function createMiddleware($action): CallableMiddlewareDecorator
    {
        return middleware(function ($req, $handler) use ($action) {
            return (new $action())->handle($req);
        });
    }
}
