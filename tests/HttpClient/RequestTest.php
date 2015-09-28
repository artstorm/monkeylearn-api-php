<?php
namespace Artstorm\MonkeyLearn\Tests\HttpClient;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\HttpClient\Request;

class RequestTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Request
     */
    protected $request;

    public function setUp()
    {
        $this->request = new Request(
            'a method',
            'a path',
            ['header' => 'header content'],
            'a body'
        );

        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldGetPath()
    {
        $this->assertEquals('a path', $this->request->getPath());
    }

    /**
     * @test
     */
    public function shouldGetBody()
    {
        $this->assertEquals('a body', $this->request->getBody());
    }

    /**
     * @test
     */
    public function shouldGetHeaders()
    {
        $this->assertEquals(['header' => 'header content'], $this->request->getHeaders());
    }
}
