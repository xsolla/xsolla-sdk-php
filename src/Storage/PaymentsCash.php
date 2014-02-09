<?php
namespace Xsolla\SDK\Storage;

class PaymentsCash implements PaymentsCashInterface
{

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
        // TODO: Implement pay() method.
    }

    public function cancel($invoiceId)
    {
        // TODO: Implement cancel() method.
    }
}
