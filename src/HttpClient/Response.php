<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class Response
{
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
}
