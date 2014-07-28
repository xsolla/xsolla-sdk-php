<?php

namespace Xsolla\SDK;

class Invoice
{
    protected $virtualCurrencyAmount;
    protected $amount;
    protected $currency;
    protected $id;
    protected $amountShoppingCart3;
    protected $currencyShoppingCart3;

    public function __construct(
        $virtualCurrencyAmount = null,
        $amount = null,
        $currency = null,
        $id = null,
        $amountShoppingCart3 = null,
        $currencyShoppingCart3 = null
    ) {
        $this->amount = $amount;
        $this->virtualCurrencyAmount = $virtualCurrencyAmount;
        $this->currency = $currency;
        $this->id = $id;
        $this->amountShoppingCart3 = $amountShoppingCart3;
        $this->currencyShoppingCart3 = $currencyShoppingCart3;
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

    public function setAmountShoppingCart3($amountShoppingCart3)
    {
        $this->amountShoppingCart3 = $amountShoppingCart3;
        return $this;
    }

    public function getAmountShoppingCart3()
    {
        return $this->amountShoppingCart3;
    }

    public function setCurrencyShoppingCart3($currencyShoppingCart3)
    {
        $this->currencyShoppingCart3 = $currencyShoppingCart3;
        return $this;
    }

    public function getCurrencyShoppingCart3()
    {
        return $this->currencyShoppingCart3;
    }

}
