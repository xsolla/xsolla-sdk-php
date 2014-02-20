<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

use Xsolla\SDK\Protocol\Storage\Pdo\PaymentStandardStorage;

class PaymentStandardStorageTest extends PaymentStorageTest
{
    const INVOICE_ID = 101;
    const INVOICE_AMOUNT = 100.20;

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
        $this->setUpPayInsertMock();

        $this->dbMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->insertMock));
        $this->dbMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(555));

        $this->assertEquals(555, $this->paymentStorage->pay(10, 10, $this->userMock, $this->datetimeObj, false));
    }

    public function testPayExists()
    {
        $this->setUpSelectMock();
        $this->selectMock->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue(array('id' => self::INVOICE_ID, 'v1' => $this->userMock->getV1(), 'amount' => self::INVOICE_AMOUNT)));

        $this->setUpPayInsertMock();
        $this->dbMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(0));

        $this->setUpPayDbMock();
        $this->dbMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->assertEquals(self::INVOICE_ID, $this->paymentStorage->pay(self::INVOICE_ID, self::INVOICE_AMOUNT, $this->userMock, $this->datetimeObj, false));
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
        $this->dbMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(0));
        $this->dbMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->setExpectedException($exceptionDesc[0], $exceptionDesc[1]);
        $this->paymentStorage->pay($result['id'], self::INVOICE_AMOUNT, $this->userMock, $this->datetimeObj, 0);
    }

    public function payErrorProvider()
    {
        return array(
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo', 'amount' => 0),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with invoiceId=101 and amount=0.00 (must be 100.20).')
            ),
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo1', 'amount' => 100.20),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with invoiceId=101 and v1=demo1 (must be "demo").')
            ),
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo1', 'amount' => 0),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with invoiceId=101 and v1=demo1 (must be "demo") and amount=0.00 (must be 100.20).')
            ),
            array(
                false,
                array('Exception', 'Temporary error.')
            )
        );
    }
}