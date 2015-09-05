<?php
namespace Artstorm\MonkeyLearn\Tests;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testTemporary()
    {
        $token = 'foobar';
        $client = new Client($token);

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Client', $client);
    }

    public function testTemporary2()
    {
        $token = 'foobar';
        $client = new Client($token);

        $api = $client->api('classification');

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Api\Classification', $api);
    }

    public function testTemporary3()
    {
        $token = 'foobar';
        $client = new Client($token);

        $api = $client->classification();

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Api\Classification', $api);
    }

    /**
     * @test
     *
     * @expectedException InvalidArgumentException
     */
    public function shouldNotFindApiGroup()
    {
        $token = 'foobar';
        $client = new Client($token);

        $client->api('foobar');
    }

    /**
     * @test
     *
     * @expectedException BadMethodCallException
     */
    public function shouldNotFindMagicApiGroup()
    {
        $token = 'foobar';
        $client = new Client($token);

        $client->foobar();
    }
}
