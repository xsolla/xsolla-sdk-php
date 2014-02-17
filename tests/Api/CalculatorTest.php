<?php

namespace Xsolla\SDK\Tests\Api;

use Xsolla\SDK\Api\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $responseMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $clientMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    protected $calculator;

    public function setUp()
    {
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', array(), array(), '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', array(), array(), '', false);
        $this->clientMock = $this->getMock('\Guzzle\Http\Client', array('get'), array(), '', false);
        $this->requestMock->expects($this->once())->method('send')->will($this->returnValue($this->responseMock));

        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->projectMock->expects($this->once())->method('getProjectId')->will($this->returnValue('projectId'));
        $this->calculator = new Calculator($this->clientMock, $this->projectMock);
    }

    public function testCalculateOut()
    {
        $this->generateAsserts('in', '/calc/inn.php');

        $this->assertEquals('in', $this->calculator->calculateIn('geotypeId', 'sum'));
    }

    public function testCalculateIn()
    {
        $this->generateAsserts('sum',  '/calc/out.php');

        $this->assertEquals('sum', $this->calculator->calculateOut('geotypeId', 'sum'));
    }

    protected function generateAsserts($return, $url)
    {
        $this->responseMock->expects($this->once())->method('getBody')->will($this->returnValue($return));

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $url,
                array(),
                array(
                    'query' => array(
                        'project_id' => 'projectId',
                        'geotype_id' => 'geotypeId',
                        'sum' => 'sum'
                    )
                ))->will($this->returnValue($this->requestMock));
    }
}
