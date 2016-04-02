<?php
namespace Artstorm\MonkeyLearn\Tests\HttpClient;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\HttpClient\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    protected $response;

    public function setUp()
    {
        $this->response = new Response(
            200,
            [
                'header' => 'some content',
                'second-header' => '999',
                'X-Query-Limit-Limit' => 123
            ],
            'a body'
        );

        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldGetStatus()
    {
        $this->assertEquals(200, $this->response->getStatus());
    }

    /**
     * @test
     */
    public function shouldGetBody()
    {
        $this->assertEquals('a body', $this->response->getBody());
    }

    /**
     * @test
     */
    public function shouldGetHeaders()
    {
        $this->assertEquals('some content', $this->response->getHeaders()['header']);
    }

    /**
     * @test
     */
    public function shouldGetHeader()
    {
        $this->assertEquals('999', $this->response->getHeader('second-header'));
    }

    /**
     * @test
     */
    public function shouldGetNullHeader()
    {
        $this->assertNull($this->response->getHeader('none-existing-header'));
    }

    /**
     * @test
     */
    public function shouldGetLimits()
    {
        $this->assertEquals(123, $this->response->limits()['X-Query-Limit-Limit']);
    }
}
