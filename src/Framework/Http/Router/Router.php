<?php

namespace Framework\Http\Router;

use Framework\Http\Router\exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface
{
	private RouteCollection $routes;
	
	public function __construct(RouteCollection $routes)
	{
		$this->routes = $routes;
	}
	
	/**
	 * @throws RequestNotMatchedException
	 */
	public function match(ServerRequestInterface $request): Result
	{
		foreach ($this->routes->getRoutes() as $route) {
			if ($route->methods && !in_array($request->getMethod(), $route->methods)) {
				throw new RequestNotMatchedException($request);
			}
			
			$pattern = preg_replace_callback('~{([^}]+)}~', function ($matches) use ($route) {
				$match = $matches[1];
				$pattern = $route->arguments[$match] ?? '[^}]+';
				return '(?' . '<' . $match . '>' . $pattern . ')';
			}, $route->path);
			
			$path = $request->getUri()->getPath();
			
			if (preg_match('~^' . $pattern . '$~', $path, $matches)) {
				return new Result(
					$route->name,
					$route->handler,
					array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY)
				);
			}
		}
		
		throw new RequestNotMatchedException($request);
	}
	
	public function generate($name, array $params): string
	{
		//TODO: Implement this method.
		return '';
	}
}