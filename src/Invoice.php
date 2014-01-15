<?php

namespace Xsolla\SDK;

class Invoice
{
    protected $out;
    protected $sum;
    protected $currency;

    function __construct($out = null, $sum = null, $currency = null)
    {
        $this->sum = $sum;
        $this->out = $out;
        $this->currency = $currency;
    }

    public function getOut()
    {
        return $this->out;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function getCurrency()
    {
        return $this->currency;
    }
}