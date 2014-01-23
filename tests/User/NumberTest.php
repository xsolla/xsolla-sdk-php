<?php

namespace Xsolla\SDK\tests\User;

use Xsolla\SDK\User\Number;

class NumberTest extends \PHPUnit_Framework_TestCase
{

    protected $projectMock;
    protected $userMock;
    protected $clientMock;
    protected $requestMock;
    protected $responseMock;
    /**
     * @var Number
     */
    protected $number;

    public function setUp()
    {
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface');
        $this->projectMock->expects($this->once())->method('getProjectId')->will($this->returnValue('projectId'));

        $this->userMock = $this->getMock('\Xsolla\SDK\User', [], [], '', false);
        $this->userMock->expects($this->once())->method('getV1')->will($this->returnValue('v1'));
        $this->userMock->expects($this->once())->method('getV2')->will($this->returnValue('v2'));
        $this->userMock->expects($this->once())->method('getV3')->will($this->returnValue('v3'));
        $this->userMock->expects($this->once())->method('getEmail')->will($this->returnValue('email'));

        $this->clientMock = $this->getMock('\Guzzle\Http\Client', [], [], '', false);
        $this->requestMock = $this->getMock('\Guzzle\Http\Message\RequestInterface', [], [], '', false);
        $this->responseMock = $this->getMock('\Guzzle\Http\Message\Response', [], [], '', false);

        $this->requestMock->expects($this->once())->method('send')->will($this->returnValue($this->responseMock));
        $this->clientMock->expects($this->once())->method('get')->with(
            '/xsolla_number.php',
            array(),
            array(
                'query' => array(
                    'project' => 'projectId',
                    'v1' => 'v1',
                    'v2' => 'v2',
                    'v3' => 'v3',
                    'email' => 'email',
                    'format' => 'json'
                )
            )
        )->will($this->returnValue($this->requestMock));

        $this->number = new Number($this->clientMock, $this->projectMock);
    }

    public function testGetNumber()
    {
        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('result' => 0, 'number' => 'number')))
        );

        $this->assertEquals('number', $this->number->getNumber($this->userMock));
    }

    public function testGetNumberInternalException()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InternalServerException', 'description', 10);

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('result' => 10, 'description' => 'description')))
        );

        $this->assertEquals('number', $this->number->getNumber($this->userMock));
    }

    public function testGetNumberInvalidArgumentException()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\InvalidArgumentException', 'description', 1);

        $this->responseMock->expects($this->once())->method('getBody')->will(
            $this->returnValue(json_encode(array('result' => 1, 'description' => 'description')))
        );

        $this->assertEquals('number', $this->number->getNumber($this->userMock));
    }
}
