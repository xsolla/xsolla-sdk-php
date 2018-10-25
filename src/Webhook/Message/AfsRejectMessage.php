<?php

namespace Xsolla\SDK\Webhook\Message;

class AfsRejectMessage extends Message
{

    /**
     * @return array
     */
    public function getTransaction()
    {
        return $this->request['transaction'];
    }


    /**
     * @return string|null
     */
    public function getExternalPaymentId()
    {
        if (array_key_exists('external_id', $this->request['transaction'])) {
            return $this->request['transaction']['external_id'];
        }
    }

    /**
     * @return array
     */
    public function getRefundDetails()
    {
        return $this->request['refund_details'];
    }

}
