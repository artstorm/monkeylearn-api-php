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
     * Extracts the relevant content from the response.
     *
     * @param  Response $response
     *
     * @return array|mixed
     */
    public function result()
    {
        $body = $this->body;
        $content = json_decode($body, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return $body;
        }

        return $content['result'];
    }

    /**
     * Get query limit headers.
     *
     * @param  array  $limits
     *
     * @return array
     */
    public function limits(array $limits = [])
    {
        $headers = [
            'X-Query-Limit-Limit',
            'X-Query-Limit-Remaining',
            'X-Query-Limit-Request-Queries'
        ];

        foreach ($headers as $header) {
            $limits[$header] = $this->getHeader($header);
        }

        return $limits;
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

    /**
     * Get response headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get a response header by key.
     *
     * @param  string $key
     *
     * @return string
     */
    public function getHeader($key)
    {
        if (array_key_exists($key, $this->headers)) {
            return $this->headers[$key];
        }
    }
}
