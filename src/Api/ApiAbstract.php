<?php

namespace Artstorm\MonkeyLearn\Api;

use Artstorm\MonkeyLearn\HttpClient\Response;
use Artstorm\MonkeyLearn\Client;

abstract class ApiAbstract
{
    /**
     * HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Assign dependencies.
     *
     * @param  Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send a POST request with JSON encoded parameters.
     *
     * @param  string $path
     * @param  array  $parameters
     * @param  array  $headers
     *
     * @return array
     */
    protected function post($path, array $parameters = [], array $headers = [])
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $headers
        );
    }

    /**
     * Send a POST request with raw data.
     *
     * @param  string $path
     * @param  mixed  $body
     * @param  array  $headers
     *
     * @return array
     */
    protected function postRaw($path, $body, array $headers = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $body,
            $headers
        );

        return $this->getResponse($response);
    }

    /**
     * Create a JSON encoded version of an array of parameters.
     *
     * @param  array $parameters
     *
     * @return null|string
     */
    protected function createJsonBody(array $parameters)
    {
        if (count($parameters) === 0) {
            return;
        }

        return json_encode($parameters);
    }

    /**
     * Extracts the relevant content from the response.
     *
     * @param  Response $response
     *
     * @return array|mixed
     */
    protected function getResponse(Response $response)
    {
        $body = $response->getBody();
        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        // Add remainin query limits to the response
        $content['limits'] = $this->getQueryLimitHeaders($response);

        return $content;
    }

    protected function getQueryLimitHeaders(Response $response, array $limits = [])
    {
        $headers = [
            'X-Query-Limit-Limit',
            'X-Query-Limit-Remaining',
            'X-Query-Limit-Request-Queries'
        ];

        foreach ($headers as $header) {
            $limits[$header] = $response->getHeader($header);
        }

        return $limits;
    }
}
