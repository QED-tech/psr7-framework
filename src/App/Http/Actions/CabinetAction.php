<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request): Response
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
