<?php
namespace Artstorm\MonkeyLearn\Tests\Api;

use GuzzleHttp\Psr7\Response;
use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\Client;

class ApiAbstractTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldPassPostRequestToClient()
    {
        $httpClient = $this->getMock('GuzzleHttp\Client', ['send']);
        $httpClient
            ->expects($this->any())
            ->method('send')
            ->willReturn(new Response(200, [], json_encode(['a body'])));

        $client = new Client('token', $httpClient);

        $api = new ApiAbstractTestInstance($client);

        $response = $api->apiPostCall('a-path');

        $this->assertTrue(is_array($response));
    }
}
