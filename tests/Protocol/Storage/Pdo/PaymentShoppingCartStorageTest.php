<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

class PaymentsShoppingCartTest extends PaymentStorageTest
{
    /**
     * @var \Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface
     */
    protected $paymentStorage;

    public function setUp()
    {
        parent::setUp();
        $this->paymentStorage = new \Xsolla\SDK\Protocol\Storage\Pdo\PaymentShoppingCartStorage($this->pdoMock);
        $this->datetimeObj = \DateTime::createFromFormat('YmdHis', '20130325184822', $this->xsollaTimeZone);
    }

    protected function setUpPayPdoMock()
    {
        $this->pdoMock->expects($this->at(0))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->updateMock));
    }

    protected function setUpPayUpdateMock()
    {
        $this->updateMock->expects($this->exactly(14))
            ->method('bindValue')
            ->with($this->anything(), $this->anything(), $this->anything());
        $this->updateMock->expects($this->at(14))
            ->method('execute');
    }

    public function testPaySuccess()
    {
        $expectedV1 = 500;

        $this->setUpPayUpdateMock();
        $this->updateMock->expects($this->at(15))
            ->method('rowCount')
            ->will($this->returnValue(1));

        $this->setUpPayPdoMock();

        $v1 = $this->paymentStorage->pay(100, 100.20, $expectedV1, null, null, 'RUR', $this->datetimeObj, 0);
        $this->assertEquals($expectedV1, $v1);
    }

    /**
     * @dataProvider payUnprocessableProvider
     */
    public function testPayUnprocessable($result, $exceptionMessage)
    {
        $this->setUpSelectMock();
        $this->setUpPayUpdateMock();
        $this->updateMock->expects($this->at(15))
            ->method('rowCount')
            ->will($this->returnValue(0));

        $this->selectMock->expects($this->at(2))
            ->method('fetch')
            ->with($this->equalTo(\PDO::FETCH_ASSOC))
            ->will($this->returnValue($result));

        $this->setUpPayPdoMock();
        $this->pdoMock->expects($this->at(1))
            ->method('prepare')
            ->with($this->anything())
            ->will($this->returnValue($this->selectMock));

        $this->setExpectedException('Xsolla\SDK\Exception\UnprocessableRequestException', $exceptionMessage);
        $this->paymentStorage->pay(
            101,
            100.50,
            500,
            null,
            null,
            'RUR',
            $this->datetimeObj,
            0
        );
    }

    public function payUnprocessableProvider()
    {
        return array(
            array(false, 'Invoice with xsolla_id = 101 not found'),
            array(
                array(
                    'v1' => 500,
                    'v2' => null,
                    'v3' => null,
                    'invoice_amount' => 100.20,
                    'invoice_currency' => 'RUR',
                    'is_dry_run' => 0,
                ),
                'Found invoice with values: v1=500, v2=NULL, v3=NULL, amount=100.20, currency=RUR, dryRun=0. ' .
                'Must be: v1=500, v2=NULL, v3=NULL, amount=100.50, currency=RUR, dryRun=0.'
            ),
        );
    }

} 