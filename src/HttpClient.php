<?php

declare(strict_types=1);

namespace JMComponents\Http;

use JMComponents\Http\Request;
use JMComponents\Http\Response;

class HttpClient
{
    /**
     * Sends an HTTP request and returns the response.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function send(Request $request): Response
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $request->getUrl(),
            CURLOPT_CUSTOMREQUEST => $request->getMethod(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->formatHeaders($request->getHeaders()),
            CURLOPT_POSTFIELDS => $request->getMethod() === 'GET' ? null : http_build_query($request->getBody())
        ]);

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($responseBody === false || $error) {
            throw new \RuntimeException("HTTP Request failed: $error");
        }

        return new Response($httpCode, $responseBody);
    }

    /**
     * Formats the given headers array into an array of strings
     * in the format "Header-Name: header-value" to be used with curl_setopt(CURLOPT_HTTPHEADER)
     *
     * @param array $headers
     * @return array
     */
    private function formatHeaders(array $headers): array
    {
        $formatted = [];

        foreach ($headers as $key => $value) {
            $formatted[] = "$key: $value";
        }
        return $formatted;
    }
}
