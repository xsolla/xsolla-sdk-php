<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

abstract class PaymentStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $pdoMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $insertMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $updateMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $selectMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $userMock;

    /**
     * @var \Xsolla\SDK\Protocol\Storage\PaymentStorageInterface
     */
    protected $paymentStorage;

    /**
     * @var \DateTime
     */
    protected $datetimeObj;

    /**
     * @var \DateTimeZone
     */
    protected $xsollaTimeZone;

    public function setUp()
    {
        $this->pdoMock = $this->getMock('Xsolla\SDK\Tests\Protocol\Storage\Pdo\PDOMock');
        $this->userMock = $this->getMock('Xsolla\SDK\User', array(), array(), '', false);
        $this->userMock->expects($this->any())
            ->method('getV1')
            ->will($this->returnValue('demo'));
        $this->insertMock = $this->getMock('PDOStatement');
        $this->updateMock = $this->getMock('PDOStatement');
        $this->selectMock = $this->getMock('PDOStatement');
        $this->xsollaTimeZone = new \DateTimeZone('Europe/Moscow');
    }

    protected function setUpSelectMock()
    {
        $this->selectMock->expects($this->at(0))
            ->method('bindValue')
            ->with($this->anything(), $this->anything(), $this->anything());
        $this->selectMock->expects($this->at(1))
            ->method('execute');
    }

    protected function setUpCancelDbMock()
    {
        $this->pdoMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->updateMock));

    }

    public function setUpCancelUpdateMock()
    {
        $this->updateMock->expects($this->at(0))
            ->method('bindValue')
            ->with($this->anything(), $this->anything(), $this->anything());
        $this->updateMock->expects($this->at(1))
            ->method('execute');
    }

    public function testCancelSuccess()
    {
        $this->setUpCancelDbMock();

        $this->setUpCancelUpdateMock();
        $this->updateMock->expects($this->at(2))
            ->method('rowCount')
            ->will($this->returnValue(1));

        $this->paymentStorage->cancel(100);
    }

    /**
     * @dataProvider cancelErrorProvider
     */
    public function testCancelError($result, $exceptionDesc)
    {
        $this->setUpSelectMock();
        $this->selectMock->expects($this->at(2))
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue($result));

        $this->setUpCancelUpdateMock();
        $this->updateMock->expects($this->at(2))
            ->method('rowCount')
            ->will($this->returnValue(0));

        $this->setUpCancelDbMock();
        $this->pdoMock->expects($this->at(1))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->setExpectedException($exceptionDesc[0], $exceptionDesc[1]);

        $this->paymentStorage->cancel(100);
    }

    public function cancelErrorProvider()
    {
        return array(
            array(
                false,
                array('Xsolla\SDK\Exception\InvoiceNotFoundException', '')
            ),
            array(
                array('is_canceled' => 0),
                array('Exception', '')
            )
        );
    }
}
