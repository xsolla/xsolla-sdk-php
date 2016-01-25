<?php

namespace Xsolla\SDK\Webhook\Message;

class GetPinCodeMessage extends Message
{
    /**
     * @return array
     */
    public function getPinCode()
    {
        if (!array_key_exists('pin_code', $this->request)) {
            return array();
        }

        return $this->request['pin_code'];
    }

    /**
     * @return string
     */
    public function getDigitalContent()
    {
        if (!array_key_exists('pin_code', $this->request)) {
            return;
        }

        return $this->request['pin_code']['digital_content'];
    }

    /**
     * @return string
     */
    public function getDRM()
    {
        if (!array_key_exists('pin_code', $this->request)) {
            return;
        }

        return $this->request['pin_code']['DRM'];
    }
}
