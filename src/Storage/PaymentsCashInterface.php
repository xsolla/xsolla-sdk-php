<?php

namespace Xsolla\SDK\Storage;

interface PaymentsCashInterface extends PaymentsInterface
{
    public function pay($invoiceId, $amount, $v1, $v2, $v3, $currency, $date, $userAmount, $userCurrency, $transferAmount, $transferCurrency, $pid, $geotype);
}
