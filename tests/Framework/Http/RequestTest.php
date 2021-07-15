<?php

namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
	public function testEmpty()
	{
		$request = new Request();
		
		$this->assertEmpty($request->getParsedBody());
		$this->assertEmpty($request->getQueryParams());
	}
	
	public function testQueryParams()
	{
		$data = [
			'data' => 'for tests'
		];
		
		$request = (new Request())
			->withQueryParams($data);
		
		$this->assertEquals($data, $request->getQueryParams());
		$this->assertEmpty($request->getParsedBody());
	}
	
	public function testParsedBody()
	{
		$request = (new Request())
			->withParsedBody($data = [
				'data' => 'for tests body'
			]);
		
		$this->assertEquals($data, $request->getParsedBody());
		$this->assertEmpty($request->getQueryParams());
	}
}
