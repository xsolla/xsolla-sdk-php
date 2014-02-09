<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\PayStandard;

class PayStandardTest extends CommandTest
{
    protected $signParams = array('command', 'v1', 'id');

    public function setUp()
    {
        parent::setUp();
        $this->command = new PayStandard($this->projectMock, $this->usersMock, $this->paymentsStandardMock);
    }

    public function testCheckSign()
    {
        $request = array(
            'command' => 'pay',
            'v1' => 'v1',
            'id' => '456'
        );
        $this->checkSignTest($request);
    }

    public function testProcess()
    {
        $request = array(
            'v1' => 'v1',
            'v2' => 'v2',
            'v3' => 'v3',
            'id' => 'id',
            'sum' => 'sum'
        );
        $this->queryMock->expects($this->any())->method('get')->will(
            $this->returnCallback(
                function ($name) use ($request) {
                    return (isset($request[$name]) ? $request[$name] : null);
                }
            )
        );

        $this->usersMock->expects($this->once())->method('check')->will($this->returnValue(true));
        $this->paymentsStandardMock->expects($this->once())
            ->method('pay')
            ->with('id', 'sum', 'v1', 'v2', 'v3')
            ->will($this->returnValue('id_shop'));
        $result = $this->command->process($this->requestMock);
        $this->assertEquals('0', $result['result']);
        $this->assertEquals('id', $result['id']);
        $this->assertEquals('id_shop', $result['id_shop']);
    }

    public function testProcessFailV1()
    {
        $this->usersMock->expects($this->once())->method('check')->will($this->returnValue(false));
        $result = $this->command->process($this->requestMock);
        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('2', $result['result']);
    }

}
