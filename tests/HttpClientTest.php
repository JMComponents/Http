<?php

declare(strict_types=1);

namespace JMComponents\Tests;

use JMComponents\Http\HttpClient;
use JMComponents\Http\Request;
use JMComponents\Http\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(HttpClient::class)]
class HttpClientTest extends TestCase
{
    public function testSendRequest(): void
    {
        $request = Request::fromBuilder(
            'GET',
            'https://jsonplaceholder.typicode.com/posts/1',
            [],
            []
        );

        $client = new HttpClient();
        $response = $client->send($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody());
    }

    public function testHttpClientHandlesErrors(): void
    {
        $request = Request::fromBuilder(
            'GET',
            'https://invalid.url',
            [],
            []
        );

        $client = new HttpClient();

        $this->expectException(\RuntimeException::class);
        $client->send($request);
    }
}
