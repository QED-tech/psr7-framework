<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
	private array $users;
	
	public function __construct(array $users)
	{
		$this->users = $users;
	}
	
	public function __invoke(ServerRequestInterface $request): Response
	{
		$username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
		$password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
		
		if ($username !== null && $password !== null) {
			foreach ($this->users as $name => $pass) {
				if ($name === $username && $pass === $password) {
					return new HtmlResponse(sprintf(
						'Cabinet action for user - %s', $username
					));
				}
			}
		}
		
		
		return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
	}
}