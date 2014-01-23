<?php

namespace Xsolla\SDK\Tests;

use Xsolla\SDK\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $user = new User('v1', 'v2', 'v3', 'email', 'phone');

        $this->assertEquals('v1', $user->getV1());
        $this->assertEquals('v2', $user->getV2());
        $this->assertEquals('v3', $user->getV3());
        $this->assertEquals('email', $user->getEmail());
        $this->assertEquals('phone', $user->getPhone());
    }
}
