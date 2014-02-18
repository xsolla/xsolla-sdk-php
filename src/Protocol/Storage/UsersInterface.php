<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\User;

interface UsersInterface
{
    public function check(User $user);
}
