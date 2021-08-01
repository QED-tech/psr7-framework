<?php

namespace Framework;

use Framework\Http\Pipelines\MiddlewareResolver;
use Laminas\Diactoros\ServerRequest;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;

class Application
{
	private MiddlewarePipe $pipeline;
	private MiddlewareResolver $resolver;
	
	public function __construct(MiddlewareResolver $resolver)
	{
		$this->pipeline = new MiddlewarePipe();
		$this->resolver = $resolver;
	}
	
	public function pipe(mixed $middleware)
	{
		$this->pipeline->pipe($this->resolver->resolve($middleware));
	}
	
	public function run(ServerRequest $request): ResponseInterface
	{
		return $this->pipeline->handle($request);
	}
}
