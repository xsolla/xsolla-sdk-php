<?php
namespace Xsolla\SDK\Storage;

use Xsolla\SDK\User;

class Users implements UsersInterface
{
    public function check(User $user)
    {
        return ($user->getV1() == 'demo');
    }
}
