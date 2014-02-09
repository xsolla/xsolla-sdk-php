<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\PayCash;

class PayCashTest extends CommandTest
{
    protected $signParams = array('v1', 'amount', 'currency', 'id');
    protected $signParamName = 'sign';

    public function setUp()
    {
        parent::setUp();
        $this->command = new PayCash($this->projectMock, $this->paymentsCashMock);
        $request = array(
            'id' => 'id',
            'amount' => 'amount',
            'v1' => 'v1',
            'v2' => 'v2',
            'v3' => 'v3',
            'currency' => 'currency',
            'datetime' => '20131212110000',
            'userAmount' => 'userAmount',
            'userCurrency' => 'userCurrency',
            'transferAmount' => 'transferAmount',
            'transferCurrency' => 'transferCurrency',
            'pid' => 'pid',
            'geotype' => 'geotype'
        );
        $this->queryBag->replace($request);
    }

    public function testCheckSign()
    {
        $request = array(
            'v1' => 'v1',
            'amount' => '123',
            'currency' => 'RUR',
            'id' => '456'
        );
        $this->checkSignTest($request);
    }

    public function testProcess()
    {
        $this->paymentsCashMock->expects($this->once())
            ->method('pay');
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_SUCCESS, $result['result']);
    }

    public function testProcessWithInvalidDateTime()
    {
        $invalidDateTimeFormat = '2014-01-01 01:01:01';
        $this->queryBag->set('datetime', $invalidDateTimeFormat);
        $result = $this->command->process($this->requestMock);
        $this->assertEquals(PayCash::CODE_ERROR_TEMPORARY, $result['result']);
        $this->assertContains($invalidDateTimeFormat, $result['description']);
    }

    public function testProcessWithFail()
    {
        $this->paymentsCashMock->expects($this->once())
            ->method('pay')
            ->will($this->throwException(new \Exception('Message')));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_ERROR_TEMPORARY, $result['result']);
        $this->assertEquals('Message', $result['description']);
    }
}
