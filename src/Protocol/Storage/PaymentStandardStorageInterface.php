<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;
use Xsolla\SDK\User;

interface PaymentStandardStorageInterface extends PaymentStorageInterface
{
    /**
     * @param  int                           $xsollaPaymentId       If this xsollaPaymentId already exists and v1, virtualCurrencyAmount, dryRun are the same, you MUST return your existent payment ID
     * @param  float                         $virtualCurrencyAmount
     * @param  User                          $user
     * @param  \DateTime                     $date
     * @param  bool                          $dryRun
     * @return int                           unique payment ID in your system
     * @throws UnprocessableRequestException
     */
    public function pay($xsollaPaymentId, $virtualCurrencyAmount, User $user, \DateTime $date, $dryRun);
}
