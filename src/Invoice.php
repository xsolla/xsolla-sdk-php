<?php

namespace Xsolla\SDK;

class Invoice
{
    protected $out;
    protected $sum;
    protected $currency;
    protected $id;

    public function __construct($out = null, $sum = null, $currency = null, $id = null)
    {
        $this->sum = $sum;
        $this->out = $out;
        $this->currency = $currency;
        $this->id = $id;
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
    public function setOut($out)
    {
        $this->out = $out;
    }

    /**
     * @param float $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }
}
