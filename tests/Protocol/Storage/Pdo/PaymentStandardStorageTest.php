<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

use Xsolla\SDK\Protocol\Storage\Pdo\PaymentStandardStorage;

class PaymentStandardStorageTest extends PaymentStorageTest
{
    /**
     * @var \Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface
     */
    protected $paymentStorage;


    public function setUp()
    {
        parent::setUp();
        $this->paymentStorage = new PaymentStandardStorage($this->dbMock);
        $this->datetimeObj = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-03-25 18:48:22', $this->xsollaTimeZone);
    }

    protected function setUpPayDbMock()
    {
        $this->dbMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->insertMock));
        $this->dbMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue($expectedId));
    }

    protected function setUpPayInsertMock()
    {
        $this->insertMock->expects($this->exactly(5))
            ->method('bindValue')
            ->with($this->anything(), $this->anything());
        $this->insertMock->expects($this->at(5))
            ->method('execute');
    }

    public function testPaySuccess()
    {
        $expectedId = 101;

        $this->setUpPayInsertMock();

        $this->dbMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->insertMock));
        $this->dbMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue($expectedId));

        $this->assertEquals($expectedId, $this->paymentStorage->pay(10, 10, $this->userMock, $this->datetimeObj, false));
    }

    public function testPayExists()
    {
        $expectedId = 101;
        $expectedAmount = 100.20;

        $this->setUpSelectMock();
        $this->selectMock->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue(array('id' => $expectedId, 'amount_virtual_currency' => $expectedAmount)));

        $this->setUpPayInsertMock();

        $this->setUpPayDbMock();
        $this->dbMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->assertEquals($expectedId, $this->paymentStorage->pay(10, $expectedAmount, $this->userMock, $this->datetimeObj, false));
    }

    /**
     * @dataProvider payErrorProvider
     */
    public function testPayError($result, $exceptionDesc)
    {
        $this->setUpSelectMock();
        $this->selectMock->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue($result));

        $this->setUpPayInsertMock();

        $this->setUpPayDbMock();
        $this->dbMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->setExpectedException($exceptionDesc[0], $exceptionDesc[1]);
        $this->paymentStorage->pay($result['id'], 100.20, $this->userMock, $this->datetimeObj, 0);
    }

    public function payErrorProvider()
    {
        return array(
            array(
                array('id' => 101, 'amount_virtual_currency' => 0),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with same invoiceId=101 and different amount=0.00 (must be 100.20).')
            ),
            array(
                false,
                array('Exception', 'Temporary error.')
            )
        );
    }
}