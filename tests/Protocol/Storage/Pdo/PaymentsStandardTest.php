<?php

namespace Xsolla\SDK\Tests\Protocol\Storage\Pdo;

class PaymentsStandardTest extends PaymentsTest
{
    /**
     * @var \Xsolla\SDK\Protocol\Storage\PaymentsStandardInterface
     */
    protected $paymentStorage;


    public function setUp()
    {
        parent::setUp();
        $this->paymentStorage = new \Xsolla\SDK\Protocol\Storage\Pdo\PaymentsStandard($this->dbMock);
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
        $this->insertMock->expects($this->exactly(4))
            ->method('bindValue')
            ->with($this->anything(), $this->anything());
        $this->insertMock->expects($this->at(4))
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

        $this->assertEquals($expectedId, $this->paymentStorage->pay(10, 10, $this->userMock, false));
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

        $this->assertEquals($expectedId, $this->paymentStorage->pay(10, $expectedAmount, $this->userMock, false));
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
        $this->paymentStorage->pay($result['id'], 100.20, $this->userMock, 0);
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