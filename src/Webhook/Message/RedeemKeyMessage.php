<?php

namespace Xsolla\SDK\Webhook\Message;

class RedeemKeyMessage extends Message
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
    public function getRestriction()
    {
        if (!array_key_exists('restriction', $this->request)) {
            return [];
        }

        return $this->request['restriction'];
    }

    /**
     * @return string
     */
    public function getKey()
    {
        if (!array_key_exists('key', $this->request)) {
            return '';
        }

        return $this->request['key'];
    }

    /**
     * @return string
     */
    public function getSku()
    {
        if (!array_key_exists('sku', $this->request)) {
            return '';
        }

        return $this->request['sku'];
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        if (!array_key_exists('user_id', $this->request)) {
            return '';
        }

        return $this->request['user_id'];
    }

    /**
     * @return string
     */
    public function getActivationDate()
    {
        if (!array_key_exists('activation_date', $this->request)) {
            return '';
        }

        return $this->request['activation_date'];
    }

    /**
     * @return string
     */
    public function getUserCountry()
    {
        if (!array_key_exists('user_country', $this->request)) {
            return '';
        }

        return $this->request['user_country'];
    }
}