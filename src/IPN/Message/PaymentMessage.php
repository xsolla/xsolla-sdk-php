<?php

namespace Xsolla\SDK\IPN\Message;

class PaymentMessage extends Message
{
    public function getPurchase()
    {
        return $this->parameterBag->get('purchase', array());
    }

    public function getTransaction()
    {
        return $this->parameterBag->get('transaction', array());
    }

    public function getPaymentDetails()
    {
        return $this->parameterBag->get('payment_details', array());
    }

    public function getCustomParameters()
    {
        return $this->parameterBag->get('custom_parameters', array());
    }

    public function isDryRun()
    {
        return $this->parameterBag->getBoolean('transaction[dry_run]');
    }
}