<?php

namespace Xsolla\SDK\Webhook\Message;

abstract class AbstractPaymentAccountMessage extends Message
{
    /**
     * @return array
     */
    public function getSettings()
    {
        if (!array_key_exists('settings', $this->request)) {
            return [];
        }

        return $this->request['settings'];
    }

    /**
     * @return array
     */
    public function getPaymentAccount()
    {
        return $this->request['payment_account'];
    }

    public function getPaymentAccountId()
    {
        return $this->request['payment_account']['id'];
    }
}