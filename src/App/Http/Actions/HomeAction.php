<?php

namespace App\Http\Actions;

use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomeAction implements RequestHandlerInterface
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderer->render('app/home');
        return (new HtmlResponse($html))
            ->withHeader('X-Developer', 'QED-tech');
    }
}
