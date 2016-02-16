<?php
namespace Artstorm\MonkeyLearn\Tests\HttpClient;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\HttpClient\CurlClient;

class CurlClientTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetCurlClientInstance()
    {
        $client = new CurlClient();

        $this->assertInstanceOf('Artstorm\MonkeyLearn\HttpClient\CurlClient', $client);
    }

    /**
     * @test
     */
    public function shouldSetOption()
    {
        $client = new CurlClient();
        $client->setOption(CURLOPT_URL, 'something');
        $info = $client->getInfo();

        $this->assertEquals('something', $info['url']);
    }

    /**
     * @test
     */
    public function shouldGetError()
    {
        $client = new CurlClient();
        $client->setOption(CURLOPT_URL, 'something');
        $client->execute();
        $error = $client->error();
        $client->close();

        $this->assertContains('something', $error);
    }
}
