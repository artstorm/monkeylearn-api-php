<?php
namespace Artstorm\MonkeyLearn\Tests\Api;

use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\Client;

class ApiAbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @return ApiAbstractTestInstance
     */
    protected function getApiMock($response = null)
    {
        $response = $response ? $response : json_encode(['a body']);

        $httpClient = $this->getMock('GuzzleHttp\Client', ['send']);
        $httpClient
            ->expects($this->any())
            ->method('send')
            ->willReturn(new Response(200, [], $response));

        $client = new Client('token', $httpClient);

        $api = new ApiAbstractTestInstance($client);

        return $api;
    }

    /**
     * @test
     */
    public function shouldPassPostRequestToClient()
    {
        $api = $this->getApiMock();

        $response = $api->apiPostCall('a-path');

        $this->assertTrue(is_array($response));
    }

    /**
     * @test
     */
    public function shouldPassPostRequestToClientWithBody()
    {
        $api = $this->getApiMock();

        $response = $api->apiPostCall('a-path', ['key' => 'value']);

        $this->assertTrue(is_array($response));
    }

    /**
     * @test
     */
    public function shouldPassPostRequestToClientWithInvalidJsonResponse()
    {
        $api = $this->getApiMock('a body not json encoded');

        $response = $api->apiPostCall('a-path', ['key' => 'value']);

        $this->assertTrue(is_string($response));
    }
}
