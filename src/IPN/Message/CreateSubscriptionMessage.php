<?php

namespace Xsolla\SDK\IPN\Message;

class CreateSubscriptionMessage extends CancelSubscriptionMessage
{
    public function getSubscription()
    {
        return $this->parameterBag->get('subscription', array());
    }

    public function getCoupon()
    {
        return $this->parameterBag->get('coupon', array());
    }
}