<?php


namespace Framework\Http;


use JetBrains\PhpStorm\Pure;

class RequestFactory
{
	#[Pure] public static function fromGlobals(array $query = null, array $body = null): Request
	{
		return (new Request)
			->withQueryParams($query ?: $_GET)
			->withParsedBody($body ?: $_POST);
	}
}