<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentsStandardInterface;
use Xsolla\SDK\User;

class PaymentsStandard extends Payments implements PaymentsStandardInterface
{
    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

    }

    public function pay($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        $id = $this->insertPay($invoiceId, $amountVirtual, $user, $dryRun);
        if ($id > 0) {
            return $id;
        }
        return $this->selectPayId($invoiceId, $amountVirtual, $user, $dryRun);

    }

    public function insertPay($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        $insert = $this->db->prepare(
            "INSERT INTO `xsolla_standard_invoice`
                (`v1`, `id_xsolla`, `amount_virtual_currency`, `is_dry_run`)
                VALUES (:v1, :id_xsolla, :amount_virtual_currency, :is_dry_run)"
        );
        $insert->bindValue(':v1', $user->getV1());
        $insert->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $insert->bindValue(':amount_virtual_currency', $amountVirtual, \PDO::PARAM_INT);
        $insert->bindValue(':is_dry_run', $dryRun, \PDO::PARAM_BOOL);
        $insert->execute();
        return $this->db->lastInsertId();
    }

    public function selectPayId($invoiceId, $amountVirtual, User $user, $dryRun)
    {
        $select = $this->db->prepare(
            "SELECT id, amount_virtual_currency, is_dry_run
                FROM `xsolla_standard_invoice`
                WHERE id_xsolla = :id_xsolla
        ");
        $select->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new \Exception('Can\'t insert payment');
        }
        if ($result['amount_virtual_currency'] != $amountVirtual)
        {
            throw new UnprocessableRequestException(sprintf(
                'Found payment with same invoiceId=%s and different amount=%s (must be %s).',
                $invoiceId,
                $result['amount_virtual_currency'],
                $amountVirtual
            ));
        }
        return $result['id'];
    }

    public function getCancelUpdateStatement()
    {
        return $this->db->prepare("
            UPDATE xsolla_standard_invoice SET
            is_canceled = 1,
            timestamp_canceled = NOW()
            WHERE id_xsolla = :id_xsolla
        ;");
    }

    public function getCancelSelectStatement()
    {
        return $this->db->prepare("
            SELECT is_canceled, timestamp_canceled
            FROM xsolla_standard_invoice
            WHERE id_xsolla = :id_xsolla
        ;");
    }

} 