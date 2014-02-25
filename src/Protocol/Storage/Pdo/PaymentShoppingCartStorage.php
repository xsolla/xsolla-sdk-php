<?php

namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCartStorageInterface;

class PaymentShoppingCartStorage extends PaymentStorage implements PaymentShoppingCartStorageInterface
{
    const TABLE = 'xsolla_shopping_cart_invoice';

    public function pay(
        $xsollaPaymentId,
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
        $notificationParams = get_defined_vars();
        if ($this->updatePayment($notificationParams)) {
            return $v1;
        }
        $existentPayment = $this->selectPayment($v1);
        if (false === $existentPayment) {
            throw new UnprocessableRequestException("Invoice with v1='$v1' not found.");
        }

        $paramsDiff = $this->getRepeatedNotificationParametersDiff($notificationParams, $existentPayment);
        if (!$paramsDiff) {
            return $v1;
        }

        $exceptionMessage = sprintf('Repeated payment notification is received for invoice v1=%s. But new payment notification parameters are not equal with previous: %s.', $v1, join(", ", $paramsDiff));
        throw new UnprocessableRequestException($exceptionMessage);
    }

    protected function getRepeatedNotificationParametersDiff(array $new, array $existent)
    {
        unset($new['datetime']);
        $existent['dryRun'] = (bool) $existent['dryRun'];

        $descriptions = array();
        $diffKeys = array_keys(array_diff_assoc($new, $existent));
        foreach($diffKeys as $key) {
            $format = $this->getSprintfFormat($new[$key]);
            $desc = sprintf(
                $format,
                $key,
                $this->convertScalarValueToString($existent[$key]),
                $this->convertScalarValueToString($new[$key])
            );
            $descriptions[] = $desc;
        }

        return $descriptions;
    }

    protected function getSprintfFormat($value)
    {
        if ('double' === gettype($value)) {
            return '%s(previous=%0.2f,repeated=%0.2f)';
        } else {
            return '%s(previous=%s,repeated=%s)';
        }
    }

    protected function convertScalarValueToString($value)
    {
        return is_null($value) ? '[null]' : $value;
    }

    protected function updatePayment(array $notificationParams)
    {
        $update = $this->pdo->prepare("
            UPDATE xsolla_shopping_cart_invoice SET
                id_xsolla = :xsollaPaymentId,
                timestamp_ipn = NOW(),
                timestamp_xsolla_ipn = FROM_UNIXTIME(:timestamp_xsolla_ipn),
                user_amount = :userAmount,
                user_currency = :userCurrency,
                transfer_amount = :transferAmount,
                transfer_currency = :transferCurrency,
                pid = :pid,
                geotype = :geotype
            WHERE v1 = :v1
                AND v2 <=> :v2
                AND v3 <=> :v3
                AND invoice_amount = :amount
                AND invoice_currency = :currency
                AND is_dry_run = :dryRun
                AND id_xsolla IS NULL
        ;");
        $update->bindValue(':xsollaPaymentId', $notificationParams['xsollaPaymentId'], \PDO::PARAM_INT);
        $datetime = $notificationParams['datetime'];
        $update->bindValue(':timestamp_xsolla_ipn', $datetime->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $update->bindValue(':userAmount', $notificationParams['userAmount']);
        $update->bindValue(':userCurrency', $notificationParams['userCurrency']);
        $update->bindValue(':transferAmount', $notificationParams['transferAmount']);
        $update->bindValue(':transferCurrency', $notificationParams['transferCurrency']);
        $update->bindValue(':pid', $notificationParams['pid'], \PDO::PARAM_INT);
        $update->bindValue(':geotype', $notificationParams['geotype'], \PDO::PARAM_INT);
        $update->bindValue(':v1', $notificationParams['v1'], \PDO::PARAM_INT);
        $update->bindValue(':v2', $notificationParams['v2']);
        $update->bindValue(':v3', $notificationParams['v3']);
        $update->bindValue(':amount', $notificationParams['amount']);
        $update->bindValue(':currency', $notificationParams['currency']);
        $update->bindValue(':dryRun', $notificationParams['dryRun'], \PDO::PARAM_BOOL);
        $update->execute();
        return (bool) $update->rowCount();
    }

    protected function selectPayment($v1)
    {
        $select = $this->pdo->prepare("
            SELECT v1, v2, v3,
                id_xsolla AS xsollaPaymentId,
                invoice_amount AS amount,
                invoice_currency AS currency,
                user_amount AS userAmount,
                user_currency AS userCurrency,
                transfer_amount AS transferAmount,
                transfer_currency AS transferCurrency,
                pid, geotype,
                is_dry_run AS dryRun
            FROM xsolla_shopping_cart_invoice
            WHERE v1 = :v1
        ;");
        $select->bindValue(':v1', $v1);
        $select->execute();
        return $select->fetch(\PDO::FETCH_ASSOC);
    }

    protected function getTable()
    {
        return self::TABLE;
    }

}
