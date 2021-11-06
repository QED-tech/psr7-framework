<?php

namespace App\Http\Actions\Blog;

use App\Entity\Blog\Post;
use Doctrine\ORM\EntityManagerInterface;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class BlogAction
{
    private TemplateRenderer $renderer;
    private EntityManagerInterface $em;

    public function __construct(TemplateRenderer $renderer, EntityManagerInterface $em)
    {
        $this->renderer = $renderer;
        $this->em = $em;
    }

    public function handle(): ResponseInterface
    {
        return new HtmlResponse($this->renderer->render(
            'app/blog/blog',
            [
                'posts' => $this
                    ->em
                    ->getRepository(Post::class)
                    ->findBy([], null, 15)
            ]
        ));
    }
}
