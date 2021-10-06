<?php

namespace App\Http\Actions;

use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AboutAction implements RequestHandlerInterface
{
	
	private TemplateRenderer $renderer;
	
	public function __construct(TemplateRenderer $renderer)
	{
		$this->renderer = $renderer;
	}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->renderer->render('app/about'));
    }
}
