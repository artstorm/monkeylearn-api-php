<?php

namespace Artstorm\MonkeyLearn;

use BadMethodCallException;
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
     * @param  string $token
     */
    public function __construct($token)
    {
        $this->token = $token;

        $this->httpClient = $this->getHttpClient();
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
    protected function getHttpClient()
    {
        if (!$this->httpClient) {
            $this->httpClient = new HttpClient([
                'base_uri' => self::BASE_URI,
                'timeout'  => 2.0,
                'headers' => ['Authorization' => 'Token '.$this->token]
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Magic method to call API groups directly via method.
     *
     * @param  string $group
     *
     * @return ApiInterface
     */
    public function __call($group, $args)
    {
        return $this->getApiObject($group);
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
