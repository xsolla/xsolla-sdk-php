<?php

namespace Xsolla\SDK\Tests;

use Xsolla\SDK\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    protected $requestMock;
    protected $responseMock;
    protected $clientMock;
    protected $projectMock;
    protected $calculator;

    public function setUp() {
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', [], [], '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', [], [], '', false);
        $this->clientMock = $this->getMock('\Guzzle\Http\Client', [], [], '', false);
        $this->requestMock->expects($this->once())->method('send')->will($this->returnValue($this->responseMock));

        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface');
        $this->projectMock->expects($this->once())->method('getProjectId')->will($this->returnValue('projectId'));
        $this->calculator = new Calculator($this->clientMock, $this->projectMock);
    }

    public function testCalculateOut()
    {
        $this->generateAsserts('in');

        $this->assertEquals('in', $this->calculator->calculateIn('geotypeId', 'sum'));
    }

    public function testCalculateIn()
    {
        $this->generateAsserts('sum');

        $this->assertEquals('sum', $this->calculator->calculateIn('geotypeId', 'sum'));
    }

    protected function generateAsserts($return)
    {
        $this->responseMock->expects($this->once())->method('getBody')->will($this->returnValue($return));

        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                '/calc/inn.php',
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
 