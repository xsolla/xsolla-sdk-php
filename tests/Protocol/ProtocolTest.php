<?php

namespace Xsolla\SDK\tests\Protocol;

use Xsolla\SDK\Protocol\Protocol;

class ProtocolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $IpCheckerMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $factoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $usersMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentsMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $queryMock;

    /**
     * @var Protocol
     */
    protected $protocol;

    public function setUp()
    {
        $this->IpCheckerMock = $this->getMock('\Xsolla\SDK\Validator\IpChecker', array(), array(), '', false);
        $this->factoryMock = $this->getMock('\Xsolla\SDK\Protocol\Command\Factory', array(), array(), '', false);
        $this->projectMock = $this->getMock('\Xsolla\SDK\Project', array(), array(), '', false);
        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');
        $this->paymentsMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsInterface');

        $this->queryMock = $this->getMock('\Symfony\Component\HttpFoundation\ParameterBag', array(), array(), '', false);
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request', array(), array(), '', false);
        $this->requestMock->query = $this->queryMock;

        $this->protocol = new Protocol($this->factoryMock, $this->projectMock, $this->usersMock, $this->paymentsMock, $this->IpCheckerMock);
    }

    public function testGet()
    {
        $this->assertSame($this->projectMock, $this->protocol->getProject());
        $this->assertSame($this->usersMock, $this->protocol->getUsers());
        $this->assertSame($this->paymentsMock, $this->protocol->getPayments());
    }

    /**
     * @dataProvider ipCheckerDataProvider
     */
    public function testGetResponse($setIpCheckerToConstructor)
    {
        $ipChecker = $setIpCheckerToConstructor ? $this->IpCheckerMock : null;
        $this->protocol = new Protocol($this->factoryMock, $this->projectMock, $this->usersMock, $this->paymentsMock, $ipChecker);
        $command = $this->getMock('\Xsolla\SDK\Protocol\Command\Check', array(), array(), '', false);
        $command->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue('result'));
        if ($setIpCheckerToConstructor) {
            $this->requestMock->expects($this->once())
                ->method('getClientIp')
                ->will($this->returnValue('client_ip'));
            $this->IpCheckerMock->expects($this->once())
                ->method('checkIp')
                ->with('client_ip');
        }
        $this->queryMock->expects($this->once())
            ->method('get')
            ->with('command')
            ->will($this->returnValue('command'));
        $this->factoryMock->expects($this->once())
            ->method('getCommand')
            ->with($this->protocol, 'command')
            ->will($this->returnValue($command)
        );
        $this->assertEquals('result', $this->protocol->getResponse($this->requestMock));
    }

    public function ipCheckerDataProvider()
    {
        return array(
            array(true),
            array(false),
        );
    }

}
