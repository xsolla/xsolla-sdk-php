<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory;
     */
    protected $factory;
    protected $projectMock;
    protected $paymentsMock;
    protected $usersMock;

    protected $protocolMock;

    public function setUp() {
        $this->factory = new Factory();
        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface');
        $this->paymentsMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsInterface');
        $this->protocolMock = $this->getMock('\Xsolla\SDK\Protocol\Standard', [], [], '', false);

        $this->protocolMock->expects($this->any())->method('getProject')->will($this->returnValue($this->projectMock));
        $this->protocolMock->expects($this->any())->method('getUsers')->will($this->returnValue($this->usersMock));
        $this->protocolMock->expects($this->any())->method('getPayments')->will($this->returnValue($this->paymentsMock));
    }

    public function testGetWrongCommand() {

        $this->setExpectedException('\Xsolla\SDK\Exception\WrongCommandException');
        $this->factory->getCommand($this->protocolMock, 'wrongCommand');
    }

    public function testGetPay() {
        $this->protocolMock->expects($this->once())->method('getProtocol')->will($this->returnValue('Cash'));

        $this->assertInstanceOf('\Xsolla\SDK\Protocol\Command\PayCash', $this->factory->getCommand($this->protocolMock, 'pay'));
    }
}
 