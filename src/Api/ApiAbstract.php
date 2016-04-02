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
     * @return Response
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
     * @return Response
     */
    protected function postRaw($path, $body, array $headers = [])
    {
        return $this->client->getHttpClient()->post(
            $path,
            $body,
            $headers
        );
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
}
