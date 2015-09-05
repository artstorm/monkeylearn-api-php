<?php

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testTemporary()
    {
        $token = 'foobar';
        $client = new Artstorm\MonkeyLearn\Client($token);

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Client', $client);
    }

    public function testTemporary2()
    {
        $token = 'foobar';
        $client = new Artstorm\MonkeyLearn\Client($token);

        $api = $client->api('classification');

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Api\Classification', $api);
    }

    public function testTemporary3()
    {
        $token = 'foobar';
        $client = new Artstorm\MonkeyLearn\Client($token);

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
        $client = new Artstorm\MonkeyLearn\Client($token);

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
        $client = new Artstorm\MonkeyLearn\Client($token);

        $client->foobar();
    }
}
