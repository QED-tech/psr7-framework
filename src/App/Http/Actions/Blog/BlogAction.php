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
		$postsRepository = $this->em->getRepository(Post::class);
		return new HtmlResponse($this->renderer->render(
			'app/blog/blog',
			[
				'posts' => $postsRepository->findBy([], null, 15)
			]
		));
	}
}
