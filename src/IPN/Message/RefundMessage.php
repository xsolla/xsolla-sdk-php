<?php

namespace Xsolla\SDK\IPN\Message;

class RefundMessage extends PaymentMessage
{
    /**
     * @return array
     */
    public function getRefundDetails()
    {
        return $this->parameterBag->get('refund_details', array());
    }
}