<?php

namespace Framework\Http\Pipelines;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private array $middlewares = [];
    
    public function __invoke(ServerRequestInterface $request, callable $default): ResponseInterface
    {
    }
    
    private function next(ServerRequestInterface $request, callable $default): ResponseInterface
    {
    }
    
    public function pipe(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }
}
