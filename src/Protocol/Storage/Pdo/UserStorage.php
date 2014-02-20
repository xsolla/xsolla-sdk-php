<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Protocol\Storage\UserStorageInterface;
use Xsolla\SDK\User;

class UserStorage implements UserStorageInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function isUserExists(User $user)
    {
        $statement = $this->pdo->prepare(
            "SELECT 1 FROM xsolla_standard_user WHERE v1 = :v1 AND v2 <=> :v2 AND v3 <=> :v3;"
        );
        $statement->bindValue(':v1', $user->getV1());
        $statement->bindValue(':v2', $user->getV2());
        $statement->bindValue(':v3', $user->getV3());
        $statement->execute();

        return (bool) $statement->fetch(\PDO::FETCH_NUM);
    }

    public function getAdditionalUserFields(User $user)
    {
        return array();
    }
}
