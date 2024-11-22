# JMComponents HTTP Library

![Packagist Version](https://img.shields.io/packagist/v/jmcomponents/http.svg)
![Tests](https://github.com/jmcomponents/http/actions/workflows/ci.yml/badge.svg)
![GitHub Release](https://img.shields.io/github/v/release/jmcomponents/http.svg)
![Packagist Downloads](https://img.shields.io/packagist/dt/jmcomponents/http.svg)
![Packagist License](https://img.shields.io/packagist/l/jmcomponents/http.svg)

A lightweight PHP library for making HTTP requests. This library provides a simple way to build HTTP requests, set headers, and handle different content types (JSON, XML, Form Data). It uses a fluent interface through a RequestBuilder class to make it easy to create and send requests.

## Installation

You can install the library using Composer. Run the following command in your project directory:

```bash
composer require jmcomponents/http
```

## Usage

### RequestBuilder

The `RequestBuilder` class allows you to construct HTTP requests easily by chaining methods.

#### Example 1: Sending a JSON request

```php
use JMComponents\Http\Builders\RequestBuilder;

$builder = new RequestBuilder();
$request = $builder
    ->setMethod('POST')
    ->setUrl('https://example.com')
    ->addHeader('Content-Type', 'application/json')
    ->setJsonBody(['key' => 'value'])
    ->build();

// Send the request using your HTTP client (e.g., Guzzle, cURL, etc.)
```

#### Example 2: Sending XML request

```php
use JMComponents\Http\Builders\RequestBuilder;

$builder = new RequestBuilder();
$request = $builder
    ->setMethod('POST')
    ->setUrl('https://example.com')
    ->addHeader('Content-Type', 'application/xml')
    ->setXmlBody('<xml><key>value</key></xml>')
    ->build();

// Send the request
```

#### Example 3: Sending Form Data request

```php
use JMComponents\Http\Builders\RequestBuilder;

$builder = new RequestBuilder();
$request = $builder
    ->setMethod('POST')
    ->setUrl('https://example.com')
    ->addHeader('Content-Type', 'application/x-www-form-urlencoded')
    ->setFormData(['key' => 'value'])
    ->build();

// Send the request
```

#### Complete Example: HTTP request using `HttpClient`

This is a complete example of how to make an HTTP request using the `RequestBuilder` to build the request and `HttpClient` to send it. Subsequently, we process the response obtained.

### Step 1: Create the request

First, we create the request using the `RequestBuilder`. We set the HTTP method, the URL, the headers and the body of the request.

```php
use JMComponents\Http\Builders\RequestBuilder;
use JMComponents\Http\HttpClient;

// Create the RequestBuilder
$builder = new RequestBuilder();

// Build the request
$request = $builder
    ->setMethod('POST') // HTTP Method
    ->setUrl('https://jsonplaceholder.typicode.com/posts') // Destination URL
    ->setHeaders([ // Headers
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer <token>' // Authorization header
    ])
    ->setJsonBody([ // JSON Body
        'title' => 'foo',
        'body' => 'bar',
        'userId' => 1
    ])
    ->build();
```

### Step 2: Send the request and get the response

Once we have the request built, we use the `HttpClient` to send it. The `HttpClient` is responsible for sending the request and receiving the response.

```php
// Create the HttpClient
$client = new HttpClient();

// Send the request and get the answer
$response = $client->send($request);

// Show the body of the response
echo $response->getBody();
```

### Step 3: Process the response

The response can be processed in different ways. In this example, we show how to convert the JSON response body to an associative array and an object.

#### Convert the response to an array

If the response has a JSON body, we can easily convert it to an array:

```php
try {
    $responseArray = $response->toArray(); // Converts the JSON response to an associative array
    print_r($responseArray);
} catch (\JsonException $e) {
    echo 'Error processing the response: ', $e->getMessage();
}
```

#### Convert the response to an object

Similarly, we can convert the response to an object:

```php
try {
    $responseObject = $response->toObject(); // Converts the JSON response to an object
    var_dump($responseObject);
} catch (\JsonException $e) {
    echo 'Error processing the response: ', $e->getMessage();
}
```

### Step 4: Handle errors

It is important to handle possible errors both in the request and in the processing of the response. Here's how to check the response status code and handle errors:

```php
// Verify the status code of the response
if ($response->getStatusCode() !== 200) {
    echo 'Error: Request failed with status code: ', $response->getStatusCode();
} else {
    echo 'Success: The application was successful.';
}
```

This example is a more structured way to make an HTTP request from scratch (using `RequestBuilder`), send it (with `HttpClient`), and handle the response. Make sure the code is well documented and looks clear to the end user who will implement it.

## Features

- **JSON Body**: Easily send JSON data by using `setJsonBody()`.
- **XML Body**: Send XML data using `setXmlBody()`.
- **Form Data**: Submit form data with `setFormData()`.
- **Headers**: Add custom headers to your requests.
- **RequestBuilder**: Chainable methods for building HTTP requests fluently.

## Methods

### RequestBuilder Class

- **setMethod(string $method)**: Set the HTTP method (e.g., `GET`, `POST`, `PUT`).
- **setUrl(string $url)**: Set the URL for the request.
- **addHeader(string $name, string $value)**: Add a custom header.
- **setJsonBody(array $data)**: Set the request body as JSON.
- **setXmlBody(string $xml)**: Set the request body as XML.
- **setFormData(array $data)**: Set the request body as form data.
- **build()**: Builds and returns the final `Request` object.

### Request Class

- **getMethod()**: Get the HTTP method of the request.
- **getUrl()**: Get the URL of the request.
- **getHeaders()**: Get the headers of the request.
- **getBody()**: Get the body of the request (can be an array or string).
- **toJson()**: Convert the request body to JSON.

### Response Class

- **getStatusCode()**: Get the status code of the response.
- **getBody()**: Get the body of the response.
- **toArray()**: Convert the response body to an associative array.
- **toObject()**: Convert the response body to an object.

## Contributing

Feel free to fork this repository and submit pull requests. Please make sure your code follows the coding standards and includes tests for any new features.

## License

This library is open-source and available under the [MIT License](LICENSE).
