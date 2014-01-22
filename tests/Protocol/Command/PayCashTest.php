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


    public function testProcess() {
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

        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('0', $result['result']);
        $this->assertEquals('id', $result['fields']['id_shop']);
    }

    public function testProcessWithFail() {
        $this->paymentsCashMock->expects($this->once())->method('pay')->will($this->throwException(new \Exception('Message', 1)));
        $result = $this->command->process($this->requestMock);

        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('5', $result['result']);
        $this->assertEquals('Message', $result['comment']);
    }
}