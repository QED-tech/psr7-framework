<?php

namespace Framework\Template;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class TwigRenderer implements TemplateRenderer
{
	private string $extension;
	private Environment $twig;
	
	public function __construct(Environment $twig, string $extension)
	{
		$this->twig = $twig;
		$this->extension = $extension;
	}
	
	/**
	 * @throws SyntaxError
	 * @throws RuntimeError
	 * @throws LoaderError
	 */
	public function render($name, array $params = []): string
	{
		return $this->twig->render($name . $this->extension, $params);
	}
}