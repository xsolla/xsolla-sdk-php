<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Check;

class CheckTest extends CommandTest
{

    protected $signParams = array('command', 'v1');

    public function setUp()
    {
        parent::setUp();
        $this->command = new Check($this->projectMock, $this->usersMock);
    }


    public function testCheckSign()
    {
        $request = array(
            'command' => 'check',
            'v1' => 'v1'
        );
        $this->checkSignTest($request);
    }

    protected function prepareProcess($return) {
        $this->requestMock->expects($this->at(0))->method('get')->with('v1')->will($this->returnValue('v1'));
        $this->requestMock->expects($this->at(1))->method('get')->with('v2')->will($this->returnValue('v2'));
        $this->requestMock->expects($this->at(2))->method('get')->with('v3')->will($this->returnValue('v3'));

        $this->usersMock->expects($this->once())->method('check')->with('v1', 'v2', 'v3')->will($this->returnValue($return));
    }
    public function testProcess()
    {
        $this->prepareProcess(true);
        $result = $this->command->process($this->requestMock);
        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('0', $result['result']);
    }

    public function testProcessNicknameNotFound()
    {
        $this->prepareProcess(false);
        $result = $this->command->process($this->requestMock);
        $this->assertArrayHasKey('result', $result);
        $this->assertEquals('7', $result['result']);
    }
}
 