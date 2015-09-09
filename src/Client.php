<?php

namespace Artstorm\MonkeyLearn;

use BadMethodCallException;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use GuzzleHttp\Client as HttpClient;

class Client
{
    /**
     * MonkeyLearn API base uri.
     *
     * @var string
     */
    const BASE_URI = 'https://api.monkeylearn.com/v2/';

    /**
     * HTTP client used for communication.
     *
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * MonkeyLearn API token.
     *
     * @var string
     */
    protected $token;

    /**
     * Default request headers.
     *
     * @var array
     */
    protected $headers = ['content-type' => 'application/json'];

    /**
     * Map group name to class names.
     *
     * @var array
     */
    protected $map = [
        'classification' => 'Classification',
    ];

    /**
     * Assign dependencies.
     *
     * @param  string     $token
     * @param  HttpClient $httpClient
     */
    public function __construct($token, HttpClient $httpClient = null)
    {
        $this->token = $token;

        $this->httpClient = $httpClient;
    }

    /**
     * Retrieve the API group to call a method within.
     *
     * @api
     *
     * @param  string $group
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($group)
    {
        if (array_key_exists($group, $this->map)) {
            $apiClass = sprintf('%s\\Api\\%s', __NAMESPACE__, $this->map[$group]);

            $api = new $apiClass($this);
        } else {
            throw new InvalidArgumentException(
                sprintf('Undefined API group called: "%s"', $group)
            );
        }

        return $api;
    }

    /**
     * Get the client to use for HTTP communication.
     *
     * @return HttpClient
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient([
                'base_uri' => self::BASE_URI,
                'timeout'  => 10.0,
                'headers' => ['Authorization' => 'Token '.$this->token]
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Make a POST request.
     *
     * @internal
     *
     * @param  string $path
     * @param  mixed  $body
     * @param  array  $headers
     *
     * @return \Guzzle\Http\Message\Request
     */
    public function post($path, $body = null, array $headers = [])
    {
        return $this->request($path, $body, 'POST', $headers);
    }

    /**
     * Send request with HTTP client.
     *
     * @param  string $path
     * @param  mixed  $body
     * @param  string $method
     * @param  array  $headers
     * @param  array  $options
     *
     * @throws ServiceUnavailableHttpException
     *
     * @return \GuzzleHttp\Psr7\Response
     */
    protected function request($path, $body = null, $method = 'GET', array $headers = [], array $options = [])
    {
        $request = $this->createRequest($method, $path, $body, $headers, $options);

        // try {
        $response = $this->getHttpClient()->send($request);
        // } catch (RequestException $e) {
        //     throw new ServiceUnavailableHttpException(null, $e->getMessage(), $e, $e->getCode());
        // }

        return $response;
    }

    /**
     * Create request with HTTP client.
     *
     * @param  string $method
     * @param  string $path
     * @param  mixed  $body
     * @param  array  $headers
     * @param  array  $options
     *
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function createRequest($method, $path, $body = null, array $headers = [], array $options = [])
    {
        return new Request(
            $method,
            $path,
            array_merge($this->headers, $headers),
            $body,
            $options
        );
    }

    /**
     * Magic method to call API groups directly via property.
     *
     * @param  string $group
     *
     * @return ApiInterface
     */
    public function __get($group)
    {
        return $this->getApiObject($group);
    }

    /**
     * Get Api Group object.
     *
     * @param  string $group
     *
     * @throws BadMethodCallException
     *
     * @return ApiInterface
     */
    protected function getApiObject($group)
    {
        try {
            return $this->api($group);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(
                sprintf('Undefined method called: "%s"', $group)
            );
        }
    }
}
