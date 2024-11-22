<?php

declare(strict_types=1);

namespace JMComponents\Tests;

use JMComponents\Http\Response;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Response::class)]
class ResponseTest extends TestCase
{
    public function testResponseProperties(): void
    {
        $response = new Response(200, '{"success":true}');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('{"success":true}', $response->getBody());
        $this->assertEquals(['success' => true], $response->toArray());
    }

    public function testInvalidJsonThrowsException(): void
    {
        $this->expectException(\JsonException::class);
        $response = new Response(200, 'invalid json');
        $response->toArray();
    }

    public function test_construct_response_with_valid_data()
    {
        $statusCode = 200;
        $body = '{"key": "value"}';
        $response = new Response($statusCode, $body);

        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($body, $response->getBody());
    }

    // Handling invalid JSON in the body when using toArray
    public function test_to_array_with_invalid_json()
    {
        $this->expectException(\JsonException::class);

        $statusCode = 200;
        $body = '{"key": "value"'; // Invalid JSON
        $response = new Response($statusCode, $body);

        $response->toArray();
    }

    // Converts JSON string in body to an object successfully
    public function test_to_object_successful_conversion()
    {
        $response = new Response(200, '{"key": "value"}');
        $result = $response->toObject();
        $this->assertIsObject($result);
        $this->assertEquals('value', $result->key);
    }

    // Handles empty JSON string gracefully
    public function test_to_object_empty_json()
    {
        $response = new Response(200, '');
        $result = $response->toObject();
        $this->assertNull($result);
    }
}
