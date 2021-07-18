<?php

namespace Framework\Http\Router;

use Framework\Http\Router\exception\RequestNotMatchedException;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
	private RouteCollection $routes;
	
	public function __construct(RouteCollection $routes)
	{
		$this->routes = $routes;
	}
	
	/**
	 * @throw RequestNotMatchedException
	 */
	public function match(ServerRequestInterface $request): Result
	{
		foreach ($this->routes->getRoutes() as $route) {
			// method validation
			
			if ($route->name === 'about') {
				return  new Result($route->name, $route->handler, $route->arguments);
			}
		}
		
		throw new RequestNotMatchedException($request);
	}
}