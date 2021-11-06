<?php

namespace App\Http\Actions;

use App\Entity\Blog\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HomeAction implements RequestHandlerInterface
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
        $html = $this->renderer->render('app/home');
        return (new HtmlResponse($html))
            ->withHeader('X-Developer', 'QED-tech');
    }
}
