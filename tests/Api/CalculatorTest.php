<?php

namespace Xsolla\SDK\Tests\Api;

use Xsolla\SDK\Api\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT_ID = 4783;
    const GEOTYPE_ID = 1;
    const SUM_VIRTUAL_AMOUNT = 11;
    const SUM_AMOUNT = 111;

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
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', array(), array(), '', false);

        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', array(), array(), '', false);
        $this->requestMock->expects($this->once())
            ->method('send')
            ->will($this->returnValue($this->responseMock));

        $this->clientMock = $this->getMock('\Guzzle\Http\Client', array(), array(), '', false);
        $this->clientMock->expects($this->at(0))
            ->method('setBaseUrl')
            ->with($this->equalTo('https://api.xsolla.com'));

        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->projectMock->expects($this->once())
            ->method('getProjectId')
            ->will($this->returnValue(self::PROJECT_ID));

        $this->calculator = new Calculator($this->clientMock, $this->projectMock);
    }

    public function testCalculateOut()
    {
        $this->generateAsserts(self::SUM_AMOUNT, self::SUM_VIRTUAL_AMOUNT, '/calc/inn.php');
        $this->assertEquals(self::SUM_VIRTUAL_AMOUNT, $this->calculator->calculateIn(self::GEOTYPE_ID, self::SUM_AMOUNT));
    }

    public function testCalculateIn()
    {
        $this->generateAsserts(self::SUM_VIRTUAL_AMOUNT, self::SUM_AMOUNT, '/calc/out.php');
        $this->assertEquals(self::SUM_AMOUNT, $this->calculator->calculateOut(self::GEOTYPE_ID, self::SUM_VIRTUAL_AMOUNT));
    }

    protected function generateAsserts($sum_input, $sum_return, $url)
    {
        $this->responseMock->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($sum_return));
        $this->clientMock->expects($this->once())
            ->method('get')
            ->with(
                $url,
                array(),
                array(
                    'query' => array(
                        'project_id' => self::PROJECT_ID,
                        'geotype_id' => self::GEOTYPE_ID,
                        'sum' => $sum_input
                    )
                ))->will($this->returnValue($this->requestMock));
    }
}
