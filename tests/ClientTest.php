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
}
