<?php

namespace App\Http\Middleware;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    private array $users;
    
    public function __construct(array $users)
    {
        $this->users = $users;
    }
    
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
        
        if ($username !== null && $password !== null) {
            foreach ($this->users as $name => $pass) {
                if ($name === $username && $pass === $password) {
                    return $next($request->withAttribute('username', $username));
                }
            }
        }
        
        
        return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
    }
}
