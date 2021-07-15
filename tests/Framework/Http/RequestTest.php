<?php

namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
	protected function setUp(): void
	{
		$_POST = [];
		$_GET = [];
	}
	
	public function testEmpty()
	{
		$request = new Request();
		
		$this->assertEmpty($request->getParsedBody());
		$this->assertEmpty($request->getQueryParams());
	}
	
	public function testQueryParams()
	{
		$_GET = $data = [
			'data' => 'for tests'
		];
		
		$request = new Request();
		
		$this->assertEquals($data, $request->getQueryParams());
		$this->assertEmpty($request->getParsedBody());
	}
}
