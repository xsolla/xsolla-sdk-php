<?php

namespace Xsolla\SDK\IPN\Message;

class UserBalanceMessage extends Message
{
    const PAYMENT = 'payment';
    const IN_GAME_PURCHASE = 'inGamePurchase';
    const COUPON = 'coupon';
    const INTERNAL = 'internal';
    const CANCELLATION = 'cancellation';

    /**
     * @return array
     */
    public function getVirtualCurrencyBalance()
    {
        if (!array_key_exists('virtual_currency_balance', $this->request)) {
            return array();
        }
        return $this->request['virtual_currency_balance'];
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->request['operation_type'];
    }

    /**
     * @return int
     */
    public function getIdOperation()
    {
        return $this->request['id_operation'];
    }

    /**
     * @return array
     */
    public function getCoupon()
    {
        if (!array_key_exists('coupon', $this->request)) {
            return array();
        }
        return $this->request['coupon'];
    }

    /**
     * @return array
     */
    public function getItemsOperationType()
    {
        if (!array_key_exists('items_operation_type', $this->request)) {
            return array();
        }
        return $this->request['items_operation_type'];
    }
}