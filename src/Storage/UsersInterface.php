<?php
namespace Xsolla\SDK\Storage;

use Xsolla\SDK\User;

interface UsersInterface
{
    public function check(User $user);
}
