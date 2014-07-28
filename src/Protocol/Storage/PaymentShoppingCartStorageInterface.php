<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentShoppingCartStorageInterface extends PaymentStorageInterface
{
    /**
     * @param  int                           $xsollaPaymentId  If this xsollaPaymentId already exists and v1, v2, v3, amount, currency dry_run are the same, you MUST return your existent payment ID
     * @param  float                         $amount
     * @param  string                        $v1 The unique identifier of the order received from the project
     * @param  string                        $v2
     * @param  string                        $v3
     * @param  string                        $currency Order currency in format ISO 4217
     * @param  \DateTime                     $datetime
     * @param  bool                          $dryRun Indication of test transaction
     * @param  float                         $userAmount
     * @param  string                        $userCurrency
     * @param  float                         $transferAmount
     * @param  string                        $transferCurrency Currency in format ISO 4217
     * @param  int                           $pid
     * @param  int                           $geotype
     * @return int
     * @throws UnprocessableRequestException
     * @return int                           unique payment ID in your system
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
