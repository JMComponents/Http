<?php

declare(strict_types=1);

namespace JMComponents\Tests\Builders;

use JMComponents\Http\Builders\RequestBuilder;
use JMComponents\Http\Request;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(RequestBuilder::class)]
class RequestBuilderTest extends TestCase
{
    public function testBuildRequest(): void
    {
        $builder = new RequestBuilder();
        $request = $builder
            ->setMethod('POST')
            ->setUrl('https://example.com')
            ->addHeader('Content-Type', 'application/json')
            ->setBody(['key' => 'value'])
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertEquals('https://example.com', $request->getUrl());
        $this->assertEquals(['Content-Type' => 'application/json'], $request->getHeaders());
        $this->assertEquals(['key' => 'value'], $request->getBody());
    }

    public function testSetJsonBody(): void
    {
        $builder = new RequestBuilder();
        $data = ['name' => 'John', 'age' => 30];
        $request = $builder
            ->setJsonBody($data)
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('application/json', $request->getHeaders()['Content-Type']);
        $this->assertEquals(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), $request->getBody());
    }

    public function testSetXmlBody(): void
    {
        $builder = new RequestBuilder();
        $xml = '<user><name>John</name><age>30</age></user>';
        $request = $builder
            ->setXmlBody($xml)
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('application/xml', $request->getHeaders()['Content-Type']);
        $this->assertEquals($xml, $request->getBody());
    }

    public function testSetFormData(): void
    {
        $builder = new RequestBuilder();
        $data = ['username' => 'john', 'password' => 'secret'];
        $request = $builder
            ->setFormData($data)
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('application/x-www-form-urlencoded', $request->getHeaders()['Content-Type']);
        $this->assertEquals(http_build_query($data), $request->getBody());
    }
}
