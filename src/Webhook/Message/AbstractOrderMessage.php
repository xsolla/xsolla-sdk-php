<?php

namespace Xsolla\SDK\Webhook\Message;

abstract class AbstractOrderMessage extends Message
{
    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->request['user']['external_id'];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->request['items'];
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->request['order'];
    }

    /**
     * @return array
     */
    public function getCustomParameters()
    {
        if (!array_key_exists('custom_parameters', $this->request)) {
            return [];
        }

        return $this->request['custom_parameters'];
    }
}