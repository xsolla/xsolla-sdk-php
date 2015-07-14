<?php

namespace Xsolla\SDK\IPN\Message;

class CreateSubscriptionMessage extends CancelSubscriptionMessage
{
    /**
     * @return array
     */
    public function getSubscription()
    {
        return $this->parameterBag->get('subscription', array());
    }

    /**
     * @return array
     */
    public function getCoupon()
    {
        return $this->parameterBag->get('coupon', array());
    }
}