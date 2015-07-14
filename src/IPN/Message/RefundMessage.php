<?php

namespace Xsolla\SDK\IPN\Message;

class RefundMessage extends PaymentMessage
{
    public function getRefundDetails()
    {
        return $this->parameterBag->get('refund_details', array());
    }
}