<?php

namespace Framework\Http\Router\Exception;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ServerRequestInterface;

class RequestNotMatchedException extends \LogicException
{
    private ServerRequestInterface $request;

    #[Pure] public function __construct(ServerRequestInterface $request)
    {
        parent::__construct('Matches not found.', 404);
        $this->request = $request;
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }
}
