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
        $request = array(
            'id' => 'id',
            'amount' => 'amount',
            'v1' => 'v1',
            'v2' => 'v2',
            'v3' => 'v3',
            'currency' => 'currency',
            'date' => 'date',
            'userAmount' => 'userAmount',
            'userCurrency' => 'userCurrency',
            'transferAmount' => 'transferAmount',
            'transferCurrency' => 'transferCurrency',
            'pid' => 'pid',
            'geotype' => 'geotype'
        );
        $this->requestMock->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function ($name) use ($request) {
                    return (isset($request[$name]) ? $request[$name] : null);
                }
            )
        );

        $this->paymentsCashMock->expects($this->once())->method('pay')->will($this->returnValue('id'));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_SUCCESS, $result['result']);
    }

    public function testProcessWithFail()
    {
        $this->paymentsCashMock->expects($this->once())->method('pay')->will($this->throwException(new \Exception('Message')));
        $result = $this->command->process($this->requestMock);

        $this->assertEquals(PayCash::CODE_ERROR_TEMPORARY, $result['result']);
        $this->assertEquals('Message', $result['description']);
    }
}
