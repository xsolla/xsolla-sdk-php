<?php

namespace Xsolla\SDK;

class Subscription
{
    protected $id;
    protected $type;
    protected $name;
    protected $currency;

    function __construct($id, $name, $type, $currency)
    {
        $this->currency = $currency;
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }
}