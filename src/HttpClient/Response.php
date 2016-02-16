<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class Response
{
    /**
     * HTTP Status code
     *
     * @int
     */
    protected $status;

    /**
     * Headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * Contents.
     *
     * @var string
     */
    protected $body;

    /**
     * Assign dependencies.
     *
     * @param int    $status
     * @param array  $headers
     * @param string $body
     */
    public function __construct($status = 200, array $headers = [], $body = null)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->body = $body;
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
     * Get HTTP status code.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
