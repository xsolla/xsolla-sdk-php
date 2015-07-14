<?php

namespace Xsolla\SDK\IPN\Message;

class UserBalanceMessage extends Message
{
    public function getVirtualCurrencyBalance()
    {
        return $this->parameterBag->get('virtual_currency_balance', array());
    }

    public function getOperationType()
    {
        return $this->parameterBag->get('operation_type');
    }

    public function getIdOperation()
    {
        return $this->parameterBag->getInt('id_operation');
    }

    public function getCoupon()
    {
        return $this->parameterBag->get('coupon', array());
    }

    public function getItemsOperationType()
    {
        return $this->parameterBag->get('items_operation_type');
    }
}