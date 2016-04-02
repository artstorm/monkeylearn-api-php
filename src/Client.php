<?php

namespace Artstorm\MonkeyLearn;

use BadMethodCallException;
use InvalidArgumentException;
use Artstorm\MonkeyLearn\HttpClient\HttpClient;
use Artstorm\MonkeyLearn\HttpClient\HttpClientInterface;

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
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * MonkeyLearn API token.
     *
     * @var string
     */
    protected $token;

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
     * @param  string              $token
     * @param  HttpClientInterface $httpClient
     */
    public function __construct($token, HttpClientInterface $httpClient = null)
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
     * @internal
     *
     * @return HttpClientInterface
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient([
                'base_uri' => self::BASE_URI,
                'headers' => [
                    'Authorization' => 'Token '.$this->token,
                    'content-type' => 'application/json'
                ]
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Enables debug data in responses.
     *
     * @return $this
     */
    public function debug()
    {
        $this->getHttpClient()->addConfigOption('debug');

        return $this;
    }

    /**
     * Enables sandbox mode for custom modules.
     *
     * @return $this
     */
    public function sandbox()
    {
        $this->getHttpClient()->addConfigOption('sandbox');

        return $this;
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
