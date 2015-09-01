<?php

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testTemporary()
    {
        $client = new Artstorm\MonkeyLearn\Client;

        $this->assertInstanceOf('Artstorm\MonkeyLearn\Client', $client);
    }
}
