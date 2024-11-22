<?php

declare(strict_types=1);

namespace JMComponents\Http;

class Request
{
    private string $method;
    private string $url;
    private array $headers;
    private array|string $body;

    /**
     * @param string $method
     * @param string $url
     * @param array<string, string> $headers
     * @param array<string, mixed> $body
     */
    private function __construct(string $method, string $url, array $headers, array|string $body)
    {
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * @param string $method The HTTP method of the request.
     * @param string $url The URL of the request.
     * @param array<string, string> $headers The headers of the request.
     * @param array<string, mixed> $body The body of the request.
     * @return static
     */
    public static function fromBuilder(string $method, string $url, array $headers, array|string $body): self
    {
        return new self($method, $url, $headers, $body);
    }

    /**
     * Returns the HTTP method of the request.
     *
     * @return string The HTTP method.
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the URL of the request.
     *
     * @return string The URL of the request.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Returns the headers of the request.
     *
     * @return array<string, string> The headers of the request.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Returns the body of the request.
     *
     * @return array<string, mixed> The body of the request.
     */
    public function getBody(): array|string
    {
        return $this->body;
    }

    /**
     * Returns the body of the request as a JSON string.
     *
     * @return string The body of the request as a JSON string.
     *
     * @throws JsonException If the body cannot be encoded as a JSON string.
     */
    public function toJson(): string
    {
        return json_encode($this->body, JSON_THROW_ON_ERROR);
    }
}
