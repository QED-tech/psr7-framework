<?php

namespace Framework\Http\Pipelines;

use Laminas\Stratigility\Middleware\CallableMiddlewareDecorator;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Laminas\Stratigility\middleware;

class MiddlewareResolver
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
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
        return is_string($action)
	        ? $this->createMiddleware($action)
	        : $action;
    }

    private function createMiddleware(string $action): MiddlewareInterface|RequestHandlerInterface
    {
	    $actionName = $this->container->get($action);
	    /** @var RequestHandlerInterface $handler */
	    $handler = new $actionName();
	    if ($handler instanceof MiddlewareInterface) {
			return $handler;
	    }
    	
        return middleware(function ($request) use ($handler) {
            return $handler->handle($request);
        });
    }
}
