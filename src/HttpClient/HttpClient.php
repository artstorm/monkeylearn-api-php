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
        // $this->base = $config['base_uri'];
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
     * @throws ServiceUnavailableHttpException
     *
     * @return Response
     */
    protected function request($path, $body = null, $method = 'GET', array $headers = [])
    {
        $request = $this->createRequest($method, $path, $body, $headers);

        // try {
        // $response = $this->getHttpClient()->send($request);
        $response = $this->send($request);
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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->buildUri($request->getPath()));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [];
        foreach ($request->getHeaders() as $key => $value) {
            array_push($headers, sprintf('%s: %s', $key, $value));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getBody());

        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) {
            echo "cURL Error: " . curl_error($ch);
        }

        return new Response($result);
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
