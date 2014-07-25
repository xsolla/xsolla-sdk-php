<?php
namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\User;

interface PaymentShoppingCart3StorageInterface extends PaymentStorageInterface
{
    /**
     * @param int $xsollaPaymentId If this xsollaPaymentId already exists and v1, paymentAmount, paymentCurrency, dryRun are the same, you MUST return your existent payment ID
     * @param float $paymentAmount
     * @param string $paymentCurrency
     * @param User $user
     * @param \DateTime $date
     * @param bool $dryRun
     * @internal param float $virtualCurrencyAmount
     * @return int unique payment ID in your system
     */
    public function pay($xsollaPaymentId, $paymentAmount, $paymentCurrency, User $user, \DateTime $date, $dryRun);
}
