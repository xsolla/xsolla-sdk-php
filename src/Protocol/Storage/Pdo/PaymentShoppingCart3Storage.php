<?php
namespace Xsolla\SDK\Protocol\Storage\Pdo;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\Protocol\Storage\PaymentShoppingCart3StorageInterface;
use Xsolla\SDK\User;

class PaymentShoppingCart3Storage extends PaymentStorage implements PaymentShoppingCart3StorageInterface
{

    const TABLE = 'xsolla_shoppingcart3_invoice';

    public function pay($xsollaPaymentId, $paymentAmount, $paymentCurrency, User $user, \DateTime $date, $dryRun)
    {
        $id = $this->insertPay($xsollaPaymentId, $paymentAmount, $paymentCurrency, $user, $date, $dryRun);
        if ($id > 0) {
            return $id;
        }
        return $this->selectPayId($xsollaPaymentId, $paymentAmount, $paymentCurrency, $user);
    }

    protected function insertPay($xsollaPaymentId, $paymentAmount, $paymentCurrency, User $user, \DateTime $date, $dryRun)
    {
        $insert = $this->pdo->prepare(
            "INSERT INTO `xsolla_shoppingcart3_invoice`
                (`v1`, `id_xsolla`, `payment_amount`, `payment_currency`, `timestamp_xsolla_ipn`, `is_dry_run`)
                VALUES (:v1, :id_xsolla, :payment_amount, :payment_currency, :timestamp_xsolla_ipn, :is_dry_run)"
        );
        $insert->bindValue(':v1', $user->getV1());
        $insert->bindValue(':id_xsolla', $xsollaPaymentId, \PDO::PARAM_INT);
        $insert->bindValue(':payment_amount', $paymentAmount);
        $insert->bindValue(':payment_currency', $paymentCurrency, \PDO::PARAM_STR);
        $insert->bindValue(':timestamp_xsolla_ipn', $date->format('Y-m-d H:i:s'), \PDO::PARAM_STR);
        $insert->bindValue(':is_dry_run', $dryRun, \PDO::PARAM_BOOL);
        $insert->execute();

        return $this->pdo->lastInsertId();
    }

    protected function selectPayId($xsollaPaymentId, $paymentAmount, $paymentCurrency, User $user)
    {
        $select = $this->pdo->prepare(
            "SELECT id, v1, `payment_amount`, `payment_currency`, timestamp_xsolla_ipn, is_dry_run
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
        if ($result['payment_amount'] != $paymentAmount) {
            $diffMessage .= sprintf(' and payment_amount=%0.2f (must be %0.2f)', $result['payment_amount'], $paymentAmount);
        }
        if ($result['payment_currency'] != $paymentCurrency) {
            $diffMessage .= sprintf(' and payment_currency=%s (must be %s)', $result['payment_currency'], $paymentCurrency);
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
        return self::TABLE;
    }
}