<?php

namespace Artstorm\MonkeyLearn\HttpClient;

class HttpClient implements HttpClientInterface
{
    /**
     * Client config.
     *
     * @var array
     */
    protected $config;

    /**
     * Assign dependencies.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Make a POST request.
     *
     * @param  string $path
     * @param  mixed  $body
     * @param  array  $headers
     *
     * @return Request
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
     *
     * @return Response
     */
    protected function request($path, $body = null, $method = 'GET', array $headers = [])
    {
        $request = $this->createRequest($method, $path, $body, $headers);
        $response = $this->send($request);

        return $response;
    }

    /**
     * Create request with HTTP client.
     *
     * @param  string $method
     * @param  string $path
     * @param  mixed  $body
     * @param  array  $headers
     *
     * @return Request
     */
    protected function createRequest($method, $path, $body = null, array $headers = [])
    {
        $defaultHeaders = isset($this->config['headers']) ? $this->config['headers'] : [];
        return new Request(
            $method,
            $path,
            array_merge($defaultHeaders, $headers),
            $body
        );
    }

    /**
     * Send the request.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function send(Request $request)
    {
        $client = new CurlClient;
        $client->setOption(CURLOPT_URL, $this->buildUri($request->getPath()));
        $client->setOption(CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        foreach ($request->getHeaders() as $key => $value) {
            array_push($headers, sprintf('%s: %s', $key, $value));
        }
        $client->setOption(CURLOPT_HTTPHEADER, $headers);

        $client->setOption(CURLOPT_POST, true);
        $client->setOption(CURLOPT_POSTFIELDS, $request->getBody());

        $result = $client->execute();

        if ($result === false) {
            return new Response(500, [], 'cURL Error: '.$client->error());
        }

        $client->close();

        return new Response(200, [], $result);
    }

    /**
     * Build uri with possible base uri.
     *
     * @param  string $uri
     *
     * @return string
     */
    private function buildUri($uri)
    {
        if (isset($this->config['base_uri'])) {
            return $this->config['base_uri'].$uri;
        }

        return $uri;
    }
}
