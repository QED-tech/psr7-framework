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
    /** @var callable */
    private $default;

    #[Pure] public function __construct(MiddlewareResolver $resolver, callable $default)
    {
        $this->resolver = $resolver;
        $this->default = $default;
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        return $this($request, $this->default);
    }

    public function pipe(mixed $middleware): Pipeline
    {
        return parent::pipe($this->resolver->resolve($middleware));
    }
}
