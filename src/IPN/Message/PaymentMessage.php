<?php

namespace Xsolla\SDK\IPN\Message;

class PaymentMessage extends Message
{
    /**
     * @return array
     */
    public function getPurchase()
    {
        return $this->parameterBag->get('purchase', array());
    }

    /**
     * @return array
     */
    public function getTransaction()
    {
        return $this->parameterBag->get('transaction', array());
    }

    /**
     * @return array
     */
    public function getPaymentDetails()
    {
        return $this->parameterBag->get('payment_details', array());
    }

    /**
     * @return array
     */
    public function getCustomParameters()
    {
        return $this->parameterBag->get('custom_parameters', array());
    }

    /**
     * @return bool
     */
    public function isDryRun()
    {
        return $this->parameterBag->getBoolean('transaction[dry_run]');
    }
}