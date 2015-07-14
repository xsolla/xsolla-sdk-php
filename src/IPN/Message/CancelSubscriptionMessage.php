<?php

namespace Xsolla\SDK\IPN\Message;

class CancelSubscriptionMessage extends Message
{
    /**
     * @return array
     */
    public function getSubscription()
    {
        return $this->parameterBag->get('subscription', array());
    }
}