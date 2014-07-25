<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

use Xsolla\SDK\Protocol\Storage\Pdo\PaymentShoppingCart3Storage;

class PaymentShoppingCart3StorageTest extends PaymentStorageTest
{
    const INVOICE_ID = 101;
    const INVOICE_AMOUNT = 100.20;
    const INVOICE_CURRENCY = 'EUR';

    /**
     * @var \Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface
     */
    protected $paymentStorage;

    public function setUp()
    {
        parent::setUp();
        $this->paymentStorage = new PaymentShoppingCart3Storage($this->pdoMock);
        $this->datetimeObj = \DateTime::createFromFormat('Y-m-d H:i:s', '2013-03-25 18:48:22', $this->xsollaTimeZone);
    }

    protected function setUpPayPdoMock()
    {
        $this->pdoMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->insertMock));
    }

    protected function setUpPayInsertMock()
    {
        $this->insertMock->expects($this->exactly(6))
            ->method('bindValue')
            ->with($this->anything(), $this->anything());
        $this->insertMock->expects($this->at(6))
            ->method('execute');
    }

    public function testPaySuccess()
    {
        $this->setUpPayInsertMock();

        $this->pdoMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->insertMock));
        $this->pdoMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(555));

        $this->assertEquals(555, $this->paymentStorage->pay(10, 10, 'EUR', $this->userMock, $this->datetimeObj, false));
    }

    public function testPayExists()
    {
        $this->setUpSelectMock();
        $this->selectMock->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue(array('id' => self::INVOICE_ID, 'v1' => $this->userMock->getV1(), 'payment_amount' => self::INVOICE_AMOUNT, 'payment_currency' => self::INVOICE_CURRENCY)));

        $this->setUpPayInsertMock();
        $this->pdoMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(0));

        $this->setUpPayPdoMock();
        $this->pdoMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->assertEquals(self::INVOICE_ID, $this->paymentStorage->pay(self::INVOICE_ID, self::INVOICE_AMOUNT, self::INVOICE_CURRENCY, $this->userMock, $this->datetimeObj, false));
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

        $this->setUpPayPdoMock();
        $this->pdoMock->expects($this->at(1))
            ->method('lastInsertId')
            ->will($this->returnValue(0));
        $this->pdoMock->expects($this->at(2))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->setExpectedException($exceptionDesc[0], $exceptionDesc[1]);
        $this->paymentStorage->pay($result['id'], self::INVOICE_AMOUNT, self::INVOICE_CURRENCY, $this->userMock, $this->datetimeObj, false);
    }

    public function payErrorProvider()
    {
        return array(
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo', 'payment_amount' => 0, 'payment_currency' => 'USD'),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with xsollaPaymentId=101 and payment_amount=0.00 (must be 100.20) and payment_currency=USD (must be EUR).')
            ),
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo1', 'payment_amount' => 100.20, 'payment_currency' => 'EUR'),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with xsollaPaymentId=101 and v1=demo1 (must be "demo").')
            ),
            array(
                array('id' => self::INVOICE_ID, 'v1' => 'demo1', 'payment_amount' => 0, 'payment_currency' => 'EUR'),
                array('Xsolla\SDK\Exception\UnprocessableRequestException', 'Found payment with xsollaPaymentId=101 and v1=demo1 (must be "demo") and payment_amount=0.00 (must be 100.20).')
            ),
            array(
                false,
                array('Exception', 'Temporary error.')
            )
        );
    }
}
