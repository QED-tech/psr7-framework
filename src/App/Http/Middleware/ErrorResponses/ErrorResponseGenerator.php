<?php

namespace App\Http\Middleware\ErrorResponses;

use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorResponseGenerator
{
	private TemplateRenderer $renderer;
	
	public function __construct(TemplateRenderer $renderer)
	{
		$this->renderer = $renderer;
	}
	
	public function generate(ServerRequestInterface $request, \Throwable $e): ResponseInterface
	{
		$view = $this->renderer->render('errors/error', [
			'error' => $e->getMessage(),
			'code' => $e->getCode()
		]);
		return new HtmlResponse($view, $e->getCode());
	}
}