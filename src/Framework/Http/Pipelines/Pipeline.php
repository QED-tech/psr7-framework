<?php

namespace Framework\Http\Pipelines;

use App\Http\Actions\NotFoundAction;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private array $middlewares = [];
    private NotFoundAction $default;

    #[Pure] public function __construct()
    {
        $this->default = new NotFoundAction();
    }

    public function __invoke(ServerRequestInterface $request, callable $default = null): ResponseInterface
    {
        return $this->next($request, $this->default);
    }

    private function next(ServerRequestInterface $request, callable $default = null): ResponseInterface
    {
        $current = array_shift($this->middlewares);
        if ($current === null) {
            return $this->default($request);
        }

        return $current($request, function (ServerRequestInterface $request) {
            return $this->next($request, $this->default);
        });
    }

    public function pipe(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }
}
