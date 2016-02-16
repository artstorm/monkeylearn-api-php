<?php
namespace Artstorm\MonkeyLearn\Tests\HttpClient;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\HttpClient\Request;
use Artstorm\MonkeyLearn\HttpClient\HttpClient;
use Artstorm\MonkeyLearn\HttpClient\HttpClientInterface;

class HttpClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetHttpClientInstance()
    {
        $client = new HttpClient();

        $this->assertInstanceOf('Artstorm\MonkeyLearn\HttpClient\HttpClientInterface', $client);
    }

    /**
     * @test
     */
    public function shouldGetResponse()
    {
        $client = new HttpClient(['base_uri' => 'http://google.com']);
        $request = new Request('get', '');
        $response = $client->send($request);

        $this->assertEquals(200, $response->getStatus());
    }

    /**
     * @test
     */
    public function shouldGetError()
    {
        $client = new HttpClient();
        $request = new Request('get', '/', ['aheader' => 'foo']);
        $response = $client->send($request);

        $this->assertContains('cURL Error', $response->getBody());
    }
}
