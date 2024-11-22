<?php

declare(strict_types=1);

namespace JMComponents\Tests;

use JMComponents\Http\Request;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Request::class)]
class RequestTest extends TestCase
{
    public function testRequestProperties(): void
    {
        $request = Request::fromBuilder(
            'GET',
            'https://example.com',
            ['Authorization' => 'Bearer token'],
            ['key' => 'value']
        );

        $this->assertEquals('GET', $request->getMethod());
        $this->assertEquals('https://example.com', $request->getUrl());
        $this->assertEquals(['Authorization' => 'Bearer token'], $request->getHeaders());
        $this->assertEquals(['key' => 'value'], $request->getBody());
        $this->assertJson($request->toJson());
    }
}
