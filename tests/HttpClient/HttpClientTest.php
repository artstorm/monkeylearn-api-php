<?php
namespace Artstorm\MonkeyLearn\Tests\HttpClient;

use PHPUnit_Framework_TestCase;
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
}
