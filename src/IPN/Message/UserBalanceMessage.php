<?php

namespace Xsolla\SDK\IPN\Message;

class UserBalanceMessage extends Message
{
    const TYPE_PAYMENT = 'payment';
    const TYPE_INGAME_PURCHASE = 'inGamePurchase';
    const TYPE_COUPON = 'coupon';
    const TYPE_INTERNAL = 'internal';
    const TYPE_CANCELLATION = 'cancellation';

    /**
     * @return array
     */
    public function getVirtualCurrencyBalance()
    {
        return $this->parameterBag->get('virtual_currency_balance', array());
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->parameterBag->get('operation_type');
    }

    /**
     * @return int
     */
    public function getIdOperation()
    {
        return $this->parameterBag->getInt('id_operation');
    }

    /**
     * @return array
     */
    public function getCoupon()
    {
        return $this->parameterBag->get('coupon', array());
    }

    /**
     * @return array
     */
    public function getItemsOperationType()
    {
        return $this->parameterBag->get('items_operation_type');
    }
}