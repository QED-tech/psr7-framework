<?php


namespace App\Http\Middleware;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorsCatcherMiddleware
{
    public function __invoke(ServerRequestInterface $request, callable $next): ResponseInterface
    {
        try {
            return $next($request);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
