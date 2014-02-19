<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\User;

interface UserStorageInterface
{
    public function check(User $user);

    public function getSpec(User $user);
}
