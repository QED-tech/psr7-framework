<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundAction
{
    public function __invoke(ServerRequestInterface $request): HtmlResponse
    {
        return new HtmlResponse('Page not found, 404');
    }
}
