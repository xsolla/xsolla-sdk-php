<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\User;

interface UserStorageInterface
{
    /**
     * @param  User $user
     * @return bool
     */
    public function isUserExists(User $user);

    /**
     * @param  User  $user
     * @return array
     */
    public function getAdditionalUserFields(User $user);
}
