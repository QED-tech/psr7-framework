<?php

namespace App\Http\Actions;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
	public function __invoke(ServerRequestInterface $request): HtmlResponse
	{
		
		return new HtmlResponse('Cabinet action');
	}
}