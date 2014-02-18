<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentsCashInterface;

class PaymentsCash extends Payments implements PaymentsCashInterface
{
    /**
     * @var \PDO
     */
    protected $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;

    }

    public function pay(
        $invoiceId,
        $amount,
        $v1,
        $v2,
        $v3,
        $currency,
        \DateTime $datetime,
        $dryRun,
        $userAmount = null,
        $userCurrency = null,
        $transferAmount = null,
        $transferCurrency = null,
        $pid = null,
        $geotype = null
    ) {
        $update = $this->db->prepare("
            UPDATE xsolla_shopping_cart_invoice SET
                id_xsolla = :id_xsolla,
                timestamp_ipn = NOW(),
                timestamp_xsolla_ipn = FROM_UNIXTIME(:timestamp_xsolla_ipn),
                user_amount = :user_amount,
                user_currency = :user_currency,
                transfer_amount = :transfer_amount,
                transfer_currency = :transfer_currency,
                pid = :pid,
                geotype = :geotype
            WHERE v1 = :v1
                AND v2 <=> :v2
                AND v3 <=> :v3
                AND invoice_amount = :invoice_amount
                AND invoice_currency = :invoice_currency
                AND is_dry_run = :is_dry_run
        ;");
        $update->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $update->bindValue(':timestamp_xsolla_ipn', $datetime->getTimestamp(), \PDO::PARAM_INT);
        $update->bindValue(':user_amount', $userAmount);
        $update->bindValue(':user_currency', $userCurrency);
        $update->bindValue(':transfer_amount', $transferAmount);
        $update->bindValue(':transfer_currency', $transferCurrency);
        $update->bindValue(':pid', $pid, \PDO::PARAM_INT);
        $update->bindValue(':geotype', $geotype, \PDO::PARAM_INT);
        $update->bindValue(':v1', $v1, \PDO::PARAM_INT);
        $update->bindValue(':v2', $v2);
        $update->bindValue(':v3', $v3);
        $update->bindValue(':invoice_amount', $amount);
        $update->bindValue(':invoice_currency', $currency);
        $update->bindValue(':is_dry_run', $dryRun, \PDO::PARAM_BOOL);
        $update->execute();
        if ($update->rowCount() == 1) {
            return $v1;
        }
        $select = $this->db->prepare("
            SELECT v1, v2, v3, invoice_amount, invoice_currency, is_dry_run
            FROM xsolla_shopping_cart_invoice
            WHERE id_xsolla = :id_xsolla
        ;");
        $select->bindValue(':id_xsolla', $invoiceId, \PDO::PARAM_INT);
        $select->execute();
        $result = $select->fetch(\PDO::FETCH_ASSOC);
        if ($result === false) {
            $exceptionMessage = 'Invoice with xsolla_id = ' . $invoiceId . ' not found';
        } else {
            $exceptionMessage = sprintf(
                'Found invoice with values: v1=%s, v2=%s, v3=%s, amount=%s, currency=%s, dryRun=%d. ' .
                'Must be: v1=%s, v2=%s, v3=%s, amount=%s, currency=%s, dryRun=%d.',
                $result['v1'],
                is_null($result['v2']) ? 'NULL' : $result['v2'],
                is_null($result['v3']) ? 'NULL' : $result['v3'],
                $result['invoice_amount'],
                $result['invoice_currency'],
                $result['is_dry_run'],
                $v1,
                is_null($v2) ? 'NULL' : $v2,
                is_null($v3) ? 'NULL' : $v3,
                $amount,
                $currency,
                $dryRun
            );
        }
        throw new UnprocessableRequestException($exceptionMessage);
    }

    public function getCancelUpdateQuery()
    {
        return "
            UPDATE xsolla_shopping_cart_invoice SET
            is_canceled = 1,
            timestamp_canceled = NOW()
            WHERE id_xsolla = :id_xsolla
        ;";
    }

    public function getCancelSelectQuery()
    {
        return "
            SELECT is_canceled, timestamp_canceled
            FROM xsolla_shopping_cart_invoice
            WHERE id_xsolla = :id_xsolla
        ;";
    }

} 