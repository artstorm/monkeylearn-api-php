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
                'second-header' => '999'
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
}
