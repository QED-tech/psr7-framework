<?php

namespace App\Http\Middleware;

use App\Http\Middleware\ErrorResponses\ErrorResponseGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorsCatcherMiddleware implements MiddlewareInterface
{
    private ErrorResponseGenerator $responseGenerator;

    public function __construct(ErrorResponseGenerator $generator)
    {
        $this->responseGenerator = $generator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (\Throwable $e) {
            return $this->responseGenerator->generate($request, $e);
        }
    }
}
