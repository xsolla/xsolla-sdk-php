<?php
namespace Xsolla\SDK\Protocol\Storage\Null;

use Xsolla\SDK\Protocol\Storage\PaymentsCashInterface;

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
        return time();//"unique" id
    }

    public function cancel($invoiceId)
    {
        //do nothing
    }
}
