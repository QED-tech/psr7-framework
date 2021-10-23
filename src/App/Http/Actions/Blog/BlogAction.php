<?php

namespace App\Http\Actions\Blog;

use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    private TemplateRenderer $renderer;

    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postID = $request->getAttribute('id', 1);
        return new HtmlResponse($this->renderer->render(
            'app/blog/show',
            [
                'post' => sprintf('lorem ipsum id - %d', $postID)
            ]
        ));
    }
}
