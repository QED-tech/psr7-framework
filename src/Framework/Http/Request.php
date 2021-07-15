<?php


namespace Framework\Http;


class Request
{
	private array $parsedBody = [];
	
	private array $queryParams = [];
	
	public function withQueryParams(array $queryParams): self
	{
		$new = clone $this;
		$new->queryParams = $queryParams;
		return $new;
	}
	
	public function withParsedBody(array $parsedBody): self
	{
		$new = clone $this;
		$new->parsedBody = $parsedBody;
		return $new;
	}
	
	public function getQueryParams(): array
	{
		return $this->queryParams;
	}
	
	public function getParsedBody(): array
	{
		return $this->parsedBody;
	}
}