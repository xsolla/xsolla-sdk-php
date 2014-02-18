<?php
namespace Xsolla\SDK\Protocol\Storage\Null;

use Xsolla\SDK\Protocol\Storage\UsersInterface;
use Xsolla\SDK\User;

class Users implements UsersInterface
{
    /**
     * @return bool You should return True if user existent in your project. False - otherwise
     */
    public function check(User $user)
    {
        return true;
    }

    public function getSpec(User $user)
    {
        return array();
    }
}
