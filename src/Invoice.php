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

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setVirtualCurrencyAmount($out)
    {
        $this->virtualCurrencyAmount = $out;
        return $this;
    }

    public function setAmount($sum)
    {
        $this->amount = $sum;
        return $this;
    }
}
