<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CabinetAction implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = $request->getAttribute('username');
        return new HtmlResponse(
            sprintf(
                'Cabinet action for user - %s',
                $username
            )
        );
    }
}
