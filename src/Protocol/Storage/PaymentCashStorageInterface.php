<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentCashStorageInterface extends PaymentStorageInterface
{
    /**
     * @param int $xsollaPaymentId
     * @param float $amount
     * @param string $v1
     * @param string $v2
     * @param string $v3
     * @param string $currency
     * @param \DateTime $datetime
     * @param bool $dryRun
     * @param float $userAmount
     * @param string $userCurrency
     * @param float $transferAmount
     * @param string $transferCurrency
     * @param int $pid
     * @param int $geotype
     * @return int
     * @throws UnprocessableRequestException
     * @return int Payment unique ID in your system
     */
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
    );
}