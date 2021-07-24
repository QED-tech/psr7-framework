<?php

namespace App\Http\Actions\Blog;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class BlogShowAction
{
    public function __invoke(ServerRequestInterface $request): JsonResponse
    {
        $postID = $request->getAttribute('id', 1);
        return new JsonResponse(
            [
                'post' => sprintf('lorem ipsum id - %d', $postID)
            ]
        );
    }
}
