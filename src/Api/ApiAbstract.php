<?php

namespace Artstorm\MonkeyLearn\Api;

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
}
