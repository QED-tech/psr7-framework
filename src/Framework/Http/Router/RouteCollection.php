<?php

namespace Framework\Http\Router;

class RouteCollection
{
	/** @var Route[] */
	private array $routes;
	
	private function addRoute(Route $route)
	{
		$this->routes[] = $route;
	}
	
	public function any(string $name, string $path, mixed $handler, array $arguments = [])
	{
		$this->addRoute(new Route($name, $path, $handler, [], $arguments));
	}
	
	/**
	 * @return Route[]
	 */
	public function getRoutes(): array
	{
		return $this->routes;
	}
}