<?php

declare(strict_types=1);

namespace JMComponents\Http\Builders;

use JMComponents\Http\Request;

class RequestBuilder
{
    protected string $method = 'GET';
    protected string $url = '';
    protected array $headers = [];
    protected array|string $body = [];

    /**
     * Sets the HTTP method of the request.
     *
     * @param string $method The HTTP method to set for the request.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setMethod(string $method): self
    {
        $this->method = strtoupper($method);
        return $this;
    }

    /**
     * Sets the URL for the request.
     *
     * @param string $url The URL to set for the request.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Adds a header to the request.
     *
     * @param string $key   The header key to add.
     * @param string $value The header value to add.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function addHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Sets multiple headers for the request.
     *
     * @param array $headers An associative array of headers to set, where the key is the header name and the value is the header value.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Sets the body of the request.
     *
     * @param array $body The body data to set for the request.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setBody(array $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Add query parameters to the request URL.
     *
     * @param array $params Associative array of query parameters.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function addQueryParams(array $params): self
    {
        $this->url .= (strpos($this->url, '?') === false ? '?' : '&') . http_build_query($params);
        return $this;
    }

    /**
     * Set basic authentication header.
     *
     * @param string $username The username for authentication.
     * @param string $password The password for authentication.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setBasicAuth(string $username, string $password): self
    {
        $credentials = base64_encode("{$username}:{$password}");
        $this->addHeader('Authorization', 'Basic ' . $credentials);
        return $this;
    }

    /**
     * Set bearer authentication header.
     *
     * @param string $token The bearer token to set in the Authorization header.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setBearerAuth(string $token): self
    {
        $this->addHeader('Authorization', "Bearer {$token}");
        return $this;
    }

    /**
     * Set a timeout for the request.
     *
     * @param int $timeout The timeout value in seconds.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setTimeout(int $timeout): self
    {
        $this->addHeader('Timeout', (string)$timeout);
        return $this;
    }

    /**
     * Set the request body as JSON.
     *
     * @param array $data The data to send in the body.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setJsonBody(array $data): self
    {
        $this->setContentType('application/json');
        $this->body = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return $this;
    }

    /**
     * Add a file to the request body.
     *
     * @param string $field The field name for the file.
     * @param string $filePath The file path of the file to upload.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function addFile(string $field, string $filePath): self
    {
        $this->addHeader('Content-Type', 'multipart/form-data');
        $this->body[$field] = new \CURLFile($filePath);
        return $this;
    }

    /**
     * Set a custom User-Agent header.
     *
     * @param string $userAgent The User-Agent string.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setUserAgent(string $userAgent): self
    {
        $this->addHeader('User-Agent', $userAgent);
        return $this;
    }

    /**
     * Enable or disable automatic redirection.
     *
     * @param bool $followRedirects Whether to follow redirects automatically.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setFollowRedirects(bool $followRedirects): self
    {
        $this->addHeader('Follow-Redirects', $followRedirects ? 'true' : 'false');
        return $this;
    }

    /**
     * Set the content type for the request body.
     *
     * @param string $contentType The content type to use.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setContentType(string $contentType): self
    {
        $this->addHeader('Content-Type', $contentType);
        return $this;
    }

    /**
     * Adds a custom header to the request.
     *
     * @param string $key The header key.
     * @param string $value The header value.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function addCustomHeader(string $key, string $value): self
    {
        $this->addHeader($key, $value);
        return $this;
    }

    /**
     * Add a cookie to the request.
     *
     * @param string $name  The cookie name.
     * @param string $value The cookie value.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function addCookie(string $name, string $value): self
    {
        $this->addHeader('Cookie', "{$name}={$value}");
        return $this;
    }

    /**
     * Set cookies for the request.
     *
     * @param array $cookies Associative array of cookies.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setCookies(array $cookies): self
    {
        foreach ($cookies as $name => $value) {
            $this->addCookie($name, $value);
        }

        return $this;
    }

    /**
     * Set the request body as XML.
     *
     * @param string $xml The XML string to send in the body.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setXmlBody(string $xml): self
    {
        $this->setContentType('application/xml');
        $this->body = $xml;
        return $this;
    }

    /**
     * Set the request body as form data (application/x-www-form-urlencoded).
     *
     * @param array $data The form data to send in the body.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setFormData(array $data): self
    {
        $this->setContentType('application/x-www-form-urlencoded');
        $this->body = http_build_query($data);
        return $this;
    }

    /**
     * Set the number of retry attempts for failed requests.
     *
     * @param int $retries Number of retry attempts.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setRetries(int $retries): self
    {
        $this->addHeader('Retries', (string)$retries);
        return $this;
    }

    /**
     * Set the acceptable status codes to consider a successful request.
     *
     * @param array $statusCodes Array of status codes (e.g., [200, 201, 202]).
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setAcceptedStatusCodes(array $statusCodes): self
    {
        $this->addHeader('Accepted-Status-Codes', implode(',', $statusCodes));
        return $this;
    }

    /**
     * Simulate a request for testing purposes.
     *
     * @param bool $simulate Whether to simulate the request or not.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function simulateRequest(bool $simulate = true): self
    {
        if ($simulate) {
            $this->addHeader('Simulate-Request', 'true');
        }

        return $this;
    }

    /**
     * Disable SSL certificate verification for the request.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function disableSslVerification(): self
    {
        $this->addHeader('SSL-Verify', 'false');
        return $this;
    }

    /**
     * Enable or disable keep-alive for the request.
     *
     * @param bool $keepAlive Whether to keep the connection alive.
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setKeepAlive(bool $keepAlive = true): self
    {
        $this->addHeader('Connection', $keepAlive ? 'keep-alive' : 'close');
        return $this;
    }

    /**
     * Make the request asynchronous (e.g., for non-blocking I/O).
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setAsyncRequest(): self
    {
        $this->addHeader('Async-Request', 'true');
        return $this;
    }

    /**
     * Set the proxy for the request.
     *
     * @param string $proxy The proxy server address (e.g., 'http://proxy.example.com:8080').
     *
     * @return self Returns the current instance for method chaining.
     */
    public function setProxy(string $proxy): self
    {
        $this->addHeader('Proxy', $proxy);
        return $this;
    }

    /**
     * Builds a Request object using the current state of the builder.
     *
     * @return Request The constructed Request object.
     */
    public function build(): Request
    {
        return Request::fromBuilder(
            $this->method,
            $this->url,
            $this->headers,
            $this->body
        );
    }
}
