<?php

namespace Xsolla\SDK\Storage\Pdo;

use Xsolla\SDK\Storage\UsersInterface;
use Xsolla\SDK\User;

class Users implements UsersInterface
{
    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

    }

    public function check(User $user)
    {
        $statement = $this->db->prepare(
            "SELECT 1 FROM xsolla_standard_user WHERE v1 = :v1 AND v2 <=> :v2 AND v3 <=> :v3;"
        );
        $statement->bindValue(':v1', $user->getV1());
        $statement->bindValue(':v2', $user->getV2());
        $statement->bindValue(':v3', $user->getV3());
        $statement->execute();
        if ($statement->fetch(\PDO::FETCH_NUM)) {
            return true;
        } else {
            return false;
        }
    }
} 