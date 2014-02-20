<?php

namespace Xsolla\SDK;

class Invoice
{
    protected $virtualCurrencyAmount;
    protected $amount;
    protected $currency;
    protected $id;

    public function __construct($virtualCurrencyAmount = null, $amount = null, $currency = null, $id = null)
    {
        $this->amount = $amount;
        $this->virtualCurrencyAmount = $virtualCurrencyAmount;
        $this->currency = $currency;
        $this->id = $id;
    }

    public function getVirtualCurrencyAmount()
    {
        return $this->virtualCurrencyAmount;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param float $out
     */
    public function setVirtualCurrencyAmount($out)
    {
        $this->virtualCurrencyAmount = $out;
    }

    /**
     * @param float $sum
     */
    public function setAmount($sum)
    {
        $this->amount = $sum;
    }
}
