<?php

namespace Xsolla\SDK\Protocol\Storage;

use Xsolla\SDK\Exception\UnprocessableRequestException;

interface PaymentsCashInterface extends PaymentsInterface
{
    /**
     * @throws UnprocessableRequestException
     * @return int Payment unique ID in your system
     */
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
    );
}
