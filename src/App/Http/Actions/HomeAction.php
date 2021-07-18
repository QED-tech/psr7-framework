<?php


namespace App\Http\Actions;


use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\MessageInterface;

class HomeAction
{
	public function __invoke(): MessageInterface|HtmlResponse
	{
		return (new HtmlResponse('Hello!'))
			->withHeader('X-Developer', 'QED-tech');
	}
}