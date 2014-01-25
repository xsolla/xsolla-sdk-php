<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory;
     */
    protected $factory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $projectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentsCashMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $paymentsStandardMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $usersMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $protocolStandardMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $protocolCashMock;

    public function setUp()
    {
        $this->factory = new Factory();
        $this->usersMock = $this->getMock('\Xsolla\SDK\Storage\UsersInterface');
        $this->projectMock = $this->getMock('\Xsolla\SDK\Storage\ProjectInterface');
        $this->paymentsCashMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsCashInterface');
        $this->paymentsStandardMock = $this->getMock('\Xsolla\SDK\Storage\PaymentsStandardInterface');
        $this->protocolStandardMock = $this->getMock('\Xsolla\SDK\Protocol\Standard', array(), array(), '', false);
        $this->protocolCashMock = $this->getMock('\Xsolla\SDK\Protocol\Cash', array(), array(), '', false);

        $this->protocolStandardMock->expects($this->any())->method('getProject')->will($this->returnValue($this->projectMock));
        $this->protocolStandardMock->expects($this->any())->method('getUsers')->will($this->returnValue($this->usersMock));
        $this->protocolStandardMock->expects($this->any())->method('getPayments')->will($this->returnValue($this->paymentsStandardMock));

        $this->protocolCashMock->expects($this->any())->method('getProject')->will($this->returnValue($this->projectMock));
        $this->protocolCashMock->expects($this->any())->method('getUsers')->will($this->returnValue($this->usersMock));
        $this->protocolCashMock->expects($this->any())->method('getPayments')->will($this->returnValue($this->paymentsCashMock));
    }

    public function testGetWrongCommand()
    {
        $this->setExpectedException('\Xsolla\SDK\Exception\WrongCommandException');
        $this->factory->getCommand($this->protocolStandardMock, 'wrongCommand');
    }

    public function testGetPayCash()
    {
        $this->protocolCashMock->expects($this->once())->method('getProtocol')->will($this->returnValue('Cash'));

        $this->assertInstanceOf('\Xsolla\SDK\Protocol\Command\PayCash', $this->factory->getCommand($this->protocolCashMock, 'pay'));
    }

    public function testGetPayStandard()
    {
        $this->protocolStandardMock->expects($this->exactly(2))->method('getProtocol')->will($this->returnValue('Standard'));

        $this->assertInstanceOf('\Xsolla\SDK\Protocol\Command\PayStandard', $this->factory->getCommand($this->protocolStandardMock, 'pay'));
    }
}
