<?php
namespace Artstorm\MonkeyLearn\Tests;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\Client;
use Artstorm\MonkeyLearn\HttpClient\Response;

class ClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetClientInstance()
    {
        $token = 'token';
        $client = new Client($token);

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Client', $client);
    }

    /**
     * @test
     */
    public function shouldCreateHttpClient()
    {
        $token = 'token';
        $client = new Client($token);

        $httpClient = $client->getHttpClient();

        $this->assertInstanceOf('Artstorm\MonkeyLearn\HttpClient\HttpClient', $httpClient);
    }

    /**
     * @test
     */
    public function shouldGetApiInstanceByApiCall()
    {
        $token = 'token';
        $client = new Client($token);

        $api = $client->api('classification');

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Api\Classification', $api);
    }

    /**
     * @test
     */
    public function shouldGetApiInstanceByMagicAttribute()
    {
        $token = 'token';
        $client = new Client($token);

        $api = $client->classification;

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Api\Classification', $api);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     */
    public function shouldNotFindApiGroup()
    {
        $token = 'token';
        $client = new Client($token);

        $client->api('noGroup');
    }

    /**
     * @test
     *
     * @expectedException BadMethodCallException
     */
    public function shouldNotFindMagicApiGroup()
    {
        $token = 'token';
        $client = new Client($token);

        $client->noGroup;
    }

    /**
     * @test
     */
    public function shouldSendPostRequest()
    {
        $httpClient = $this->getMock('Artstorm\MonkeyLearn\HttpClient\HttpClient', ['send']);
        $httpClient
            ->expects($this->any())
            ->method('send')
            ->willReturn(new Response(''));
        $token = 'token';

        $client = new Client($token, $httpClient);
        $response = $client->getHttpClient()->post('a-path');

        $this->assertInstanceOf('Artstorm\MonkeyLearn\HttpClient\Response', $response);
    }
}
