<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentStandardStorageInterface;
use Xsolla\SDK\User;

class PaymentStandardStorage extends PaymentStorage implements PaymentStandardStorageInterface
{
    const table = 'xsolla_standard_invoice';

    public function pay($xsollaPaymentId, $amountVirtual, User $user, \DateTime $date, $dryRun)
    {
        $id = $this->insertPay($xsollaPaymentId, $amountVirtual, $user, $date, $dryRun);
        if ($id > 0) {
            return $id;
        }
        return $this->selectPayId($xsollaPaymentId, $amountVirtual, $user);

    }

    protected function insertPay($xsollaPaymentId, $amountVirtual, User $user, \DateTime $date, $dryRun)
    {
        $insert = $this->pdo->prepare(
            "INSERT INTO `xsolla_standard_invoice`
                (`v1`, `id_xsolla`, `amount_virtual_currency`, `timestamp_xsolla_ipn`, `is_dry_run`)
                VALUES (:v1, :id_xsolla, :amount_virtual_currency, :timestamp_xsolla_ipn, :is_dry_run)"
        );
        $insert->bindValue(':v1', $user->getV1());
        $insert->bindValue(':id_xsolla', $xsollaPaymentId, \PDO::PARAM_INT);
        $insert->bindValue(':amount_virtual_currency', $amountVirtual, \PDO::PARAM_INT);
        $insert->bindValue(':timestamp_xsolla_ipn', $date->getTimestamp());
        $insert->bindValue(':is_dry_run', $dryRun, \PDO::PARAM_BOOL);
        $insert->execute();
        return $this->pdo->lastInsertId();
    }

    protected function selectPayId($xsollaPaymentId, $amountVirtual, User $user)
    {
        $select = $this->pdo->prepare(
            "SELECT id, v1, amount_virtual_currency as amount, timestamp_xsolla_ipn, is_dry_run
                FROM `xsolla_standard_invoice`
                WHERE id_xsolla = :id_xsolla
        ");
        $select->bindValue(':id_xsolla', $xsollaPaymentId, \PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            throw new \Exception('Temporary error.');
        }
        $diffMessage = '';
        if ($result['v1'] != $user->getV1()) {
            $diffMessage .= sprintf(' and v1=%s (must be "%s")', $result['v1'], $user->getV1());
        }
        if ($result['amount'] != $amountVirtual) {
            $diffMessage .= sprintf(' and amount=%0.2f (must be %0.2f)', $result['amount'], $amountVirtual);
        }
        if ($diffMessage !== '') {
            throw new UnprocessableRequestException(sprintf(
                'Found payment with xsollaPaymentId=%s%s.',
                $xsollaPaymentId,
                $diffMessage
            ));
        }
        return $result['id'];
    }

    protected function getTable()
    {
        return self::table;
    }

} 