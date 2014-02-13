<?php

namespace Xsolla\SDK\tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\PayStandard;
use Xsolla\SDK\User;

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

    /**
     * @dataProvider dryRunDataProvider
     */
    public function testProcess($dryRunQueryParameter, $expectedDryRun)
    {
        $request = array(
            'v1' => 'v1',
            'v2' => 'v2',
            'v3' => 'v3',
            'id' => 'id',
            'sum' => 'sum',
        );
        if (!is_null($dryRunQueryParameter)) {
            $request['dry_run'] = $dryRunQueryParameter;
        }
        $this->queryBag->replace($request);

        $user = new User('v1', 'v2', 'v3');
        $this->usersMock->expects($this->once())
            ->method('check')
            ->with($user)
            ->will($this->returnValue(true));
        $this->paymentsStandardMock->expects($this->once())
            ->method('pay')
            ->with('id', 'sum', $user, $expectedDryRun)
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
