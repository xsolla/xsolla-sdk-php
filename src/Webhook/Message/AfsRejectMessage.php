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
     * @return array
     */
    public function getRefundDetails()
    {
        return $this->request['refund_details'];
    }

}
