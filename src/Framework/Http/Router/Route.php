<?php

namespace Framework\Http\Router;

class Route
{
	public string $name;
	public string $path;
	public mixed $handler;
	public array $methods;
	public array $arguments;
	
	public function __construct(string $name, string $path, mixed $handler, array $methods, array $arguments)
	{
		$this->name = $name;
		$this->path = $path;
		$this->handler = $handler;
		$this->methods = $methods;
		$this->arguments = $arguments;
	}
}