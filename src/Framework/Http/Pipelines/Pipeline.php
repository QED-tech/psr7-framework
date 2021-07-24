<?php

namespace Framework\Http\Pipelines;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private array $middlewares = [];

    public function __invoke(ServerRequestInterface $request, callable $default): ResponseInterface
    {
        return $this->next($request, $default);
    }

    private function next(ServerRequestInterface $request, callable $default): ResponseInterface
    {
        $current = array_shift($this->middlewares);
        if ($current === null) {
            return $default($request);
        }

        return $current($request, function (ServerRequestInterface $request) use ($default) {
            return $this->next($request, $default);
        });
    }

    public function pipe(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }
}
