<?php

namespace App\Http\Actions\Blog;

use App\Entity\Blog\Post;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogShowAction implements RequestHandlerInterface
{

    private TemplateRenderer $renderer;
    private EntityManagerInterface $em;

    public function __construct(TemplateRenderer $renderer, EntityManagerInterface $em)
    {
        $this->renderer = $renderer;
        $this->em = $em;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postID = $request->getAttribute('id', 1);
        $post = $this
            ->em
            ->getRepository(Post::class)
            ->findOneBy(['id' => $postID]);

        return new HtmlResponse($this->renderer->render(
            'app/blog/show',
            [
                'post' => $post
            ]
        ));
    }
}
