<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class Request
{
    /**
     * Method.
     *
     * @var string
     */
    protected $method;

    /**
     * Path.
     *
     * @var string
     */
    protected $path;

    /**
     * Method.
     *
     * @var array
     */
    protected $headers;

    /**
     * Body.
     *
     * @var string
     */
    protected $body;

    /**
     * Assign dependencie.
     *
     * @param string $method
     * @param string $path
     * @param array  $headers
     * @param string $body
     */
    public function __construct($method, $path, array $headers = [], $body)
    {
        $this->method = $method;
        $this->path = $path;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
