<?php

namespace App\Http\Actions\Blog;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class BlogShowAction implements RequestHandlerInterface
{

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postID = $request->getAttribute('id', 1);
        return new JsonResponse(
            [
                'post' => sprintf('lorem ipsum id - %d', $postID)
            ]
        );
    }
}
