<?php

namespace Xsolla\SDK\tests;

use Xsolla\SDK\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $user = new User('1_v1', '1_v2', '1_v3', '1_email', '1_phone', '1_ip');

        $this->assertEquals('1_v1', $user->getV1());
        $this->assertEquals('1_v2', $user->getV2());
        $this->assertEquals('1_v3', $user->getV3());
        $this->assertEquals('1_email', $user->getEmail());
        $this->assertEquals('1_phone', $user->getPhone());
        $this->assertEquals('1_ip', $user->getUserIP());

        $user = $user->setV1('2_v1')
            ->setV2('2_v2')
            ->setV3('2_v3')
            ->setEmail('2_email')
            ->setPhone('2_phone')
            ->setUserIp('2_ip');

        $this->assertEquals('2_v1', $user->getV1());
        $this->assertEquals('2_v2', $user->getV2());
        $this->assertEquals('2_v3', $user->getV3());
        $this->assertEquals('2_email', $user->getEmail());
        $this->assertEquals('2_phone', $user->getPhone());
        $this->assertEquals('2_ip', $user->getUserIP());
    }
}
