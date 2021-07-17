<?php


namespace Framework\Http;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request implements ServerRequestInterface
{
	private null|array|object $parsedBody;
	
	private array $queryParams;
	
	public function withQueryParams(array $query): self
	{
		$new = clone $this;
		$new->queryParams = $query;
		return $new;
	}
	
	public function withParsedBody($data): self
	{
		$new = clone $this;
		$new->parsedBody = $data;
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
	
	public function withAttribute($name, $value)
	{
	}
	
	public function getServerParams()
	{
	}
	
	public function getCookieParams()
	{
	}
	
	public function withCookieParams(array $cookies)
	{
	}
	
	public function getUploadedFiles()
	{
	}
	
	public function withUploadedFiles(array $uploadedFiles)
	{
	}
	
	public function getAttributes()
	{
	}
	
	public function getAttribute($name, $default = null)
	{
	}
	
	public function withoutAttribute($name)
	{
	}
	
	public function getProtocolVersion()
	{
	}
	
	public function withProtocolVersion($version)
	{
	}
	
	public function getHeaders()
	{
	}
	
	public function hasHeader($name)
	{
	}
	
	public function getHeader($name)
	{
	}
	
	public function getHeaderLine($name)
	{
	}
	
	public function withHeader($name, $value)
	{
	}
	
	public function withAddedHeader($name, $value)
	{
	}
	
	public function withoutHeader($name)
	{
	}
	
	public function getBody()
	{
	}
	
	public function withBody(StreamInterface $body)
	{
	}
	
	public function getRequestTarget()
	{
	}
	
	public function withRequestTarget($requestTarget)
	{
	}
	
	public function getMethod()
	{
	}
	
	public function withMethod($method)
	{
	}
	
	public function getUri()
	{
	}
	
	public function withUri(UriInterface $uri, $preserveHost = false)
	{
	}
}