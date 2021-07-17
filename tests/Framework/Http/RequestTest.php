<?php

namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
	public function testEmpty()
	{
		$request = (new Request())
			->withParsedBody([])
			->withQueryParams([]);
		
		$this->assertEmpty($request->getParsedBody());
		$this->assertEmpty($request->getQueryParams());
	}
	
	public function testQueryParams()
	{
		$data = [
			'data' => 'for tests'
		];
		$request = (new Request())
			->withQueryParams($data)
			->withParsedBody([]);
		
		$this->assertEquals($data, $request->getQueryParams());
		$this->assertEmpty($request->getParsedBody());
	}
	
	public function testParsedBody()
	{
		$data = [
			'data' => 'for tests body'
		];
		$request = (new Request())
			->withParsedBody($data)
			->withQueryParams([]);
		
		$this->assertEquals($data, $request->getParsedBody());
		$this->assertEmpty($request->getQueryParams());
	}
}
