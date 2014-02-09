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
        $userAmount,
        $userCurrency,
        $transferAmount,
        $transferCurrency,
        $pid,
        $geotype
    ) {
        // TODO: Implement pay() method.
    }

    public function cancel($invoiceId)
    {
        // TODO: Implement cancel() method.
    }
}
