<?php

namespace Framework;

use Framework\Http\Pipelines\MiddlewareResolver;
use Framework\Http\Pipelines\Pipeline;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Pipeline
{
    private MiddlewareResolver $resolver;

    #[Pure] public function __construct(MiddlewareResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        return $this($request);
    }

    public function pipe(mixed $middleware): Pipeline
    {
        return parent::pipe($this->resolver->resolve($middleware));
    }
}
