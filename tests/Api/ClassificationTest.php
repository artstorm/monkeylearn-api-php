<?php
namespace Artstorm\MonkeyLearn\Tests\Api;

use PHPUnit_Framework_TestCase;
use Artstorm\MonkeyLearn\Client;

class ClassificationTest extends PHPUnit_Framework_TestCase
{
    protected function getApiMock($apiClass)
    {
        $client = new Client('token');

        return $this->getMockBuilder('Artstorm\\MonkeyLearn\\Api\\'.$apiClass)
            ->setMethods(['get', 'post', 'postRaw', 'delete', 'put'])
            ->setConstructorArgs([$client])
            ->getMock();
    }

    /**
     * @test
     */
    public function shouldClassifyText()
    {
        $data = [
            'text_list' => $text = ['foo', 'bar']
        ];
        $classifierId = 'foobar';

        $api = $this->getApiMock('Classification');

        $api->expects($this->once())
            ->method('post')
            ->with('classifiers/'.$classifierId.'/classify/', $data);

        $api->classify($text, $classifierId);
    }
}
