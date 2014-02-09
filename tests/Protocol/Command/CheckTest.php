<?php

namespace Xsolla\SDK\Tests\Protocol\Command;

use Xsolla\SDK\Protocol\Command\Check;
use Xsolla\SDK\User;

class CheckTest extends CommandTest
{
    const V1 = 'example_v1';
    const V2 = 'example_v2';
    const V3 = 'example_v3';

    protected $signParams = array('command', 'v1');

    public function setUp()
    {
        parent::setUp();
        $this->command = new Check($this->projectMock, $this->usersMock);
        $this->queryBag->set('v1', self::V1);
        $this->queryBag->set('v2', self::V2);
        $this->queryBag->set('v3', self::V3);
    }

    public function testCheckSign()
    {
        $request = array(
            'command' => 'check',
            'v1' => 'v1'
        );
        $this->checkSignTest($request);
    }

    protected function initUsersMock($hasUser)
    {
        $user = new User(self::V1, self::V2, self::V3);
        $this->usersMock->expects($this->once())
            ->method('check')
            ->with($user)
            ->will($this->returnValue($hasUser));
    }
    public function testProcess()
    {
        $this->initUsersMock(true);
        $result = $this->command->process($this->requestMock);
        $this->assertEquals('0', $result['result']);
    }

    public function testProcessNicknameNotFound()
    {
        $this->initUsersMock(false);
        $result = $this->command->process($this->requestMock);
        $this->assertEquals('7', $result['result']);
    }
}
