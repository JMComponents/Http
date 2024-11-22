<?php

declare(strict_types=1);

namespace JMComponents\Http;

class Response
{
    private int $statusCode;
    private string $body;

    /**
     * Initializes a new instance of the Response class.
     *
     * @param int $statusCode The HTTP status code of the response.
     * @param string $body The body of the response.
     */
    public function __construct(int $statusCode, string $body)
    {
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    /**
     * Returns the HTTP status code of the response.
     *
     * @return int The HTTP status code.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Returns the body of the response.
     *
     * @return string The body of the response.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Converts the JSON string in the body to an array.
     *
     * Returns an empty array if the body is empty.
     *
     * @return array The body of the response as an array.
     * @throws JsonException If the body cannot be parsed as a JSON string.
     */
    public function toArray(): array
    {
        if (empty($this->body)) {
            return [];
        }

        return json_decode($this->body, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Returns the body of the response as a string.
     *
     * @return string The body of the response.
     */
    public function __toString(): string
    {
        return $this->body;
    }

    /**
     * Converts the JSON string in the body to an object.
     *
     * Returns an empty object if the body is empty.
     *
     * @return object The body of the response as an object.
     * @throws JsonException If the body cannot be parsed as a JSON string.
     */
    public function toObject(): ?object
    {
        if (empty($this->body)) {
            return null;
        }

        return json_decode($this->body, false, 512, JSON_THROW_ON_ERROR);
    }
}
